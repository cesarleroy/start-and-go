<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Contratacion;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoPortalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $alumno = Alumno::where('rfc', $user->rfc_alumno)
            ->orWhereRaw('LOWER(TRIM(correo)) = ?', [mb_strtolower(trim($user->email))])
            ->first();

        // Respaldo: si el alumno se registró antes de que recepción lo diera de alta, vincular RFC ahora
        if ($alumno && !$user->rfc_alumno) {
            $user->update(['rfc_alumno' => $alumno->rfc]);
        }

        $paquetes = Contratacion::orderBy('precio', 'asc')->get();

        if (!$alumno) {
            return view('alumnos.portal', [
                'alumno' => null,
                'paquetes' => $paquetes,
                'contratoActivo' => null,
                'paqueteActual' => null,
                'progreso' => null,
                'alertaTiempo' => [
                    'tipo' => 'sin_expediente',
                    'titulo' => 'Expediente de alumno no vinculado',
                    'mensaje' => 'Tu cuenta aún no está asociada a un RFC en recepción. Pide en sucursal que registren tu expediente con el correo: ' . $user->email,
                ],
                'proximasCitas' => collect(),
                'historialCitas' => collect(),
                'eventosCalendario' => [],
            ]);
        }

        // Último pago vigente (sin reembolso)
        $contratoActivo = Pago::where('rfc_cliente', $alumno->rfc)
            ->where(function ($q) {
                $q->where('reembolso', false)->orWhereNull('reembolso');
            })
            ->orderBy('fecha_pago', 'desc')
            ->first();

        $paqueteActual = $contratoActivo
            ? Contratacion::where('tipo_contratacion', $contratoActivo->tipo_contratacion)->first()
            : null;

        // Citas vinculadas al alumno (y a la fecha_pago del contrato activo)
        $citasQuery = DB::table('agenda')
            ->leftJoin('empleados', 'agenda.rfc_emp', '=', 'empleados.rfc')
            ->select(
                'agenda.*',
                DB::raw("CONCAT(empleados.nombre, ' ', empleados.apellido_p, ' ', COALESCE(empleados.apellido_m, '')) as instructor_nombre")
            )
            ->where('agenda.rfc_cliente', $alumno->rfc);

        if ($contratoActivo) {
            $citasQuery->whereDate('agenda.fecha_pago', $contratoActivo->fecha_pago);
        }

        $citas = $citasQuery
            ->orderBy('agenda.fecha', 'asc')
            ->orderBy('agenda.hora', 'asc')
            ->get();

        $hoy = Carbon::today();

        $proximasCitas = $citas->filter(fn ($c) => Carbon::parse($c->fecha)->gte($hoy))->values();
        $historialCitas = $citas->filter(fn ($c) => Carbon::parse($c->fecha)->lt($hoy))
            ->sortByDesc('fecha')
            ->values();

        // Cálculo de días y horas (cada LECCIÓN equivale a 1 día = horas_por_dia del paquete)
        $diasContratados = $paqueteActual ? $paqueteActual->dias_incluidos : 0;
        $horasPorDia = $paqueteActual ? $paqueteActual->horas_por_dia : 0;
        $horasContratadas = $paqueteActual ? (int) $paqueteActual->horas_incluidas : 0;

        $diasTomados = $citas->filter(
            fn ($c) => mb_strtoupper($c->actividad) === 'LECCIÓN' && Carbon::parse($c->fecha)->lt($hoy)
        )->count();

        $diasAgendadosFuturos = $citas->filter(
            fn ($c) => mb_strtoupper($c->actividad) === 'LECCIÓN' && Carbon::parse($c->fecha)->gte($hoy)
        )->count();

        $horasTomadas = $diasTomados * $horasPorDia;
        $horasAgendadasFuturas = $diasAgendadosFuturos * $horasPorDia;

        $diasComprometidos = $diasTomados + $diasAgendadosFuturos;
        $diasRestantesPorTomar = max(0, $diasContratados - $diasTomados);
        $diasSinAgendar = max(0, $diasContratados - $diasComprometidos);

        $horasRestantesPorTomar = $diasRestantesPorTomar * $horasPorDia;
        $horasSinAgendar = $diasSinAgendar * $horasPorDia;

        $porcentajeCompletado = $diasContratados > 0
            ? min(100, (int) round(($diasTomados / $diasContratados) * 100))
            : 0;

        $porcentajeAgendado = $diasContratados > 0
            ? min(100 - $porcentajeCompletado, (int) round(($diasAgendadosFuturos / $diasContratados) * 100))
            : 0;

        $ultimoExamen = $citas->filter(fn ($c) => mb_strtoupper($c->actividad) === 'EXAMEN')
            ->sortByDesc('fecha')
            ->first();

        $progreso = [
            'dias_contratados' => $diasContratados,
            'dias_tomados' => $diasTomados,
            'dias_agendados_futuros' => $diasAgendadosFuturos,
            'dias_restantes_por_tomar' => $diasRestantesPorTomar,
            'dias_sin_agendar' => $diasSinAgendar,
            'horas_por_dia' => $horasPorDia,
            'horas_contratadas' => $horasContratadas,
            'horas_tomadas' => $horasTomadas,
            'horas_agendadas_futuras' => $horasAgendadasFuturas,
            'horas_restantes_por_tomar' => $horasRestantesPorTomar,
            'horas_sin_agendar' => $horasSinAgendar,
            'porcentaje_completado' => $porcentajeCompletado,
            'porcentaje_agendado' => $porcentajeAgendado,
            'km_acumulados' => $citas->sum('km_recorridos'),
            'ultimo_examen' => $ultimoExamen,
            'aprobo_examen' => $ultimoExamen && $ultimoExamen->exam_prac !== null
                ? ((int) $ultimoExamen->exam_prac >= 80)
                : null,
        ];

        $alertaTiempo = $this->evaluarAlertaTiempo($contratoActivo, $paqueteActual, $progreso);

        $eventosCalendario = $citas->map(function ($cita) use ($hoy) {
            $fecha = Carbon::parse($cita->fecha);
            $esExamen = mb_strtoupper($cita->actividad) === 'EXAMEN';

            return [
                'id' => $cita->id,
                'fecha' => $fecha->format('Y-m-d'),
                'hora' => substr((string) $cita->hora, 0, 5),
                'actividad' => $cita->actividad,
                'es_examen' => $esExamen,
                'pasada' => $fecha->lt($hoy),
                'instructor' => trim($cita->instructor_nombre) ?: 'Por asignar',
                'notas' => $cita->notas ?? 'Sin notas adicionales',
                'km' => $cita->km_recorridos,
                'exam_teo' => $cita->exam_teo,
                'exam_prac' => $cita->exam_prac,
            ];
        })->values()->all();

        return view('alumnos.portal', compact(
            'alumno',
            'paquetes',
            'contratoActivo',
            'paqueteActual',
            'progreso',
            'alertaTiempo',
            'proximasCitas',
            'historialCitas',
            'eventosCalendario'
        ));
    }

    private function evaluarAlertaTiempo($contratoActivo, $paqueteActual, array $progreso): array
    {
        if (!$contratoActivo || !$paqueteActual) {
            return [
                'tipo' => 'sin_paquete',
                'titulo' => 'Sin paquete activo contratado',
                'mensaje' => 'Actualmente no cuentas con un paquete vigente registrado. Consulta los paquetes disponibles abajo y acude a recepción para inscribirte.',
            ];
        }

        if ($progreso['horas_restantes_por_tomar'] <= 0) {
            return [
                'tipo' => 'agotado',
                'titulo' => '¡Has agotado todo el tiempo de tu paquete!',
                'mensaje' => "Ya consumiste los {$progreso['dias_contratados']} días ({$progreso['horas_contratadas']} hrs totales) de tu paquete {$paqueteActual->tipo_contratacion}. Si deseas clases adicionales, contrata una renovación en recepción.",
            ];
        }

        if ($progreso['dias_sin_agendar'] <= 0) {
            return [
                'tipo' => 'todo_agendado',
                'titulo' => 'Tiempo 100% agendado en calendario',
                'mensaje' => "Ya tienes programados todos los días de tu paquete ({$progreso['dias_tomados']} tomados + {$progreso['dias_agendados_futuros']} próximos). No te quedan sesiones sueltas por agendar.",
            ];
        }

        if ($progreso['dias_sin_agendar'] <= 2) {
            return [
                'tipo' => 'por_agotar',
                'titulo' => 'Te queda poco tiempo disponible',
                'mensaje' => "Solo te restan {$progreso['dias_sin_agendar']} día(s) ({$progreso['horas_sin_agendar']} hrs) por agendar de tu paquete {$paqueteActual->tipo_contratacion}.",
            ];
        }

        return [
            'tipo' => 'activo',
            'titulo' => 'Paquete activo con tiempo disponible',
            'mensaje' => "Llevas {$progreso['dias_tomados']} de {$progreso['dias_contratados']} días ({$progreso['horas_tomadas']}/{$progreso['horas_contratadas']} hrs). Aún tienes {$progreso['dias_sin_agendar']} días ({$progreso['horas_sin_agendar']} hrs) libres por agendar.",
        ];
    }
}