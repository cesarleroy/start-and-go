<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        $empleados = [
            ['rfc' => 'GARC900101HDF', 'nombre' => 'ANA', 'apellido_p' => 'GARCÍA', 'apellido_m' => 'LOPEZ', 'puesto' => 'INSTRUCTORA', 'turno' => 'Matutino', 'descansos' => 'LUNES,MARTES', 'sexo' => 'Femenino', 'fecha_nac' => '1990-01-01', 'tel_personal' => 5541234567, 'calle' => 'MIGUEL HIDALGO', 'numero' => 12, 'colonia' => 'DEL VALLE', 'alcaldia' => 'BENITO JUÁREZ'],
            ['rfc' => 'LOPE920304MDF', 'nombre' => 'LUIS', 'apellido_p' => 'LOPEZ', 'apellido_m' => 'MORALES', 'puesto' => 'ADMINISTRADOR', 'turno' => 'Matutino', 'descansos' => 'SÁBADO,DOMINGO', 'sexo' => 'Masculino', 'fecha_nac' => '1992-03-04', 'tel_personal' => 5512345678, 'calle' => 'INSURGENTES SUR', 'numero' => 245, 'colonia' => 'NÁPOLES', 'alcaldia' => 'BENITO JUÁREZ'],
            ['rfc' => 'VELM870610HDF', 'nombre' => 'MARIO', 'apellido_p' => 'VELAZQUEZ', 'apellido_m' => 'MARTINEZ', 'puesto' => 'INSTRUCTOR', 'turno' => 'Matutino', 'descansos' => 'MIÉRCOLES,VIERNES', 'sexo' => 'Masculino', 'fecha_nac' => '1987-06-10', 'tel_personal' => 5578912345, 'calle' => 'TACUBA', 'numero' => 77, 'colonia' => 'SAN RAFAEL', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'REYG940420HDF', 'nombre' => 'GABRIEL', 'apellido_p' => 'REYES', 'apellido_m' => 'GUTIÉRREZ', 'puesto' => 'INSTRUCTOR', 'turno' => 'Matutino', 'descansos' => 'SÁBADO,DOMINGO', 'sexo' => 'Masculino', 'fecha_nac' => '1994-04-20', 'tel_personal' => 5522233344, 'calle' => 'FRAY SERVANDO', 'numero' => 88, 'colonia' => 'OBRERA', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'SALM860927MDF', 'nombre' => 'MONICA', 'apellido_p' => 'SALAZAR', 'apellido_m' => 'MORA', 'puesto' => 'INSTRUCTORA', 'turno' => 'Vespertino', 'descansos' => 'VIERNES,SÁBADO', 'sexo' => 'Femenino', 'fecha_nac' => '1986-09-27', 'tel_personal' => 5533344455, 'calle' => 'EJE CENTRAL', 'numero' => 333, 'colonia' => 'CENTRO', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'LOZR970708HDF', 'nombre' => 'RAFAEL', 'apellido_p' => 'LOZANO', 'apellido_m' => 'RIVERA', 'puesto' => 'INSTRUCTOR', 'turno' => 'Vespertino', 'descansos' => 'MARTES,JUEVES', 'sexo' => 'Masculino', 'fecha_nac' => '1997-07-08', 'tel_personal' => 5544455566, 'calle' => 'PATRIOTISMO', 'numero' => 11, 'colonia' => 'ESPARTACO', 'alcaldia' => 'COYOACÁN'],
        ];
        
        foreach($empleados as &$emp) { $emp['created_at'] = now(); $emp['updated_at'] = now(); }
        DB::table('empleados')->insertOrIgnore($empleados);

        $alumnos = [
            ['rfc' => 'JUAP910101HDF', 'nombre' => 'JUAN', 'apellido_p' => 'PÉREZ', 'apellido_m' => 'ALVAREZ', 'fecha_nac' => '1991-01-01', 'calle' => 'REFORMA', 'numero' => '100', 'colonia' => 'CENTRO', 'alcaldia' => 'CUAUHTÉMOC', 'permiso' => 'SI', 'observaciones' => 'Nervioso', 'correo' => 'jperez@test.com'],
            ['rfc' => 'MARG920202MDF', 'nombre' => 'MARÍA', 'apellido_p' => 'GÓMEZ', 'apellido_m' => 'RAMÍREZ', 'fecha_nac' => '1992-02-02', 'calle' => 'INSURGENTES', 'numero' => '200', 'colonia' => 'DEL VALLE', 'alcaldia' => 'BENITO JUÁREZ', 'permiso' => 'SI', 'observaciones' => 'Ninguna', 'correo' => 'mgomez@test.com'],
            ['rfc' => 'LUIC930303HDF', 'nombre' => 'LUIS', 'apellido_p' => 'CANO', 'apellido_m' => 'SANTOS', 'fecha_nac' => '1993-03-03', 'calle' => 'MIGUEL HIDALGO', 'numero' => '35', 'colonia' => 'POLANCO', 'alcaldia' => 'MIGUEL HIDALGO', 'permiso' => 'EN TRÁMITE', 'observaciones' => 'Usa lentes', 'correo' => 'lcano@test.com'],
            ['rfc' => 'SAND940404MDF', 'nombre' => 'SANDRA', 'apellido_p' => 'MARTÍNEZ', 'apellido_m' => 'LARA', 'fecha_nac' => '1994-04-04', 'calle' => 'DIVISIÓN DEL NORTE', 'numero' => '80', 'colonia' => 'PORTALES', 'alcaldia' => 'BENITO JUÁREZ', 'permiso' => 'NO', 'observaciones' => 'Diabética', 'correo' => 'smartinez@test.com'],
            ['rfc' => 'CARF950505HDF', 'nombre' => 'CARLOS', 'apellido_p' => 'FLORES', 'apellido_m' => 'MEJÍA', 'fecha_nac' => '1995-05-05', 'calle' => 'ZARAGOZA', 'numero' => '150', 'colonia' => 'MOCTEZUMA', 'alcaldia' => 'VENUSTIANO CARRANZA', 'permiso' => 'SI', 'observaciones' => 'Ninguna', 'correo' => 'cflores@test.com'],
        ];
        
        foreach($alumnos as &$al) { $al['created_at'] = now(); $al['updated_at'] = now(); }
        DB::table('alumnos')->insertOrIgnore($alumnos);

        $pagos = [];
        $formasPago = ['EFECTIVO', 'DEBITO', 'CRÉDITO', 'TRANSFERENCIA'];
        $tiposContratacion = ['BÁSICO', 'INTERMEDIO', 'PREMIUM', 'INTENSIVO'];
        $precios = ['BÁSICO' => 2000, 'INTERMEDIO' => 3500, 'PREMIUM' => 5000, 'INTENSIVO' => 4000];

        foreach ($alumnos as $alumno) {
            $numPagos = rand(1, 3);
            
            for ($i = 0; $i < $numPagos; $i++) {
                $mes = rand(1, 12);
                $dia = rand(1, 28);
                $fechaPago = Carbon::create(2025, $mes, $dia);
                
                $existe = false;
                foreach($pagos as $p) {
                    if($p['rfc_cliente'] == $alumno['rfc'] && $p['fecha_pago'] == $fechaPago->format('Y-m-d')) {
                        $existe = true; break;
                    }
                }
                if ($existe) continue;

                $tipo = $tiposContratacion[array_rand($tiposContratacion)];
                
                $pagos[] = [
                    'rfc_cliente' => $alumno['rfc'],
                    'fecha_pago' => $fechaPago->format('Y-m-d'),
                    'tipo_contratacion' => $tipo,
                    'total_pago' => $precios[$tipo],
                    'forma_pago' => $formasPago[array_rand($formasPago)],
                    'reembolso' => (rand(1, 100) > 90), // 10% de probabilidad de reembolso
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('pagos')->insertOrIgnore($pagos);

        $agenda = [];
        $instructores = array_filter($empleados, fn($e) => str_contains($e['puesto'], 'INSTRUCTOR'));
        $rfcsInstructores = array_column($instructores, 'rfc');
        
        foreach ($pagos as $pago) {
            $clasesPorPago = rand(1, 4);
            $fechaBase = Carbon::parse($pago['fecha_pago']);

            for ($j = 0; $j < $clasesPorPago; $j++) {
                $diasDespues = rand(1, 30);
                $fechaCita = $fechaBase->copy()->addDays($diasDespues);
                
                $hora = Carbon::createFromTime(rand(9, 18), 0, 0);

                $rfcInstructor = $rfcsInstructores[array_rand($rfcsInstructores)];

                $duplicado = false;
                foreach($agenda as $cita) {
                    if($cita['fecha'] == $fechaCita->format('Y-m-d') && 
                       $cita['hora'] == $hora->format('H:i:s') && 
                       $cita['rfc_emp'] == $rfcInstructor) {
                        $duplicado = true; break;
                    }
                }
                if ($duplicado) continue;

                $esExamen = (rand(1, 10) > 8);

                $agenda[] = [
                    'rfc_emp' => $rfcInstructor,
                    'fecha' => $fechaCita->format('Y-m-d'),
                    'hora' => $hora->format('H:i:s'),
                    'rfc_cliente' => $pago['rfc_cliente'],
                    'fecha_pago' => $pago['fecha_pago'],
                    'actividad' => $esExamen ? 'EXAMEN' : 'LECCIÓN',
                    'km_recorridos' => rand(5, 25),
                    'notas' => $esExamen ? 'Evaluación final' : 'Práctica de estacionamiento',
                    'exam_teo' => $esExamen ? rand(60, 100) : null,
                    'exam_prac' => $esExamen ? rand(60, 100) : null,
                    'notas_resultado' => $esExamen ? (rand(0,1) ? 'Aprobado' : 'Reprobado') : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('agenda')->insertOrIgnore($agenda);
    }
}