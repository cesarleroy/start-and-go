<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Empleado;
use App\Models\Alumno;
use App\Models\Pago;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        // Obtener agendas con relaciones
        $agendas = Agenda::with(['empleado', 'alumno'])
                        ->orderBy('fecha', 'desc')
                        ->orderBy('hora')
                        ->get();
        
        // Listas para los filtros o modales si se necesitan
        $empleados = Empleado::select('rfc', 'nombre', 'apellido_p', 'apellido_m')
                            ->orderBy('nombre')
                            ->get();
        
        $alumnos = Alumno::select('rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        return view('agenda.index', compact('agendas', 'empleados', 'alumnos'));
    }

    public function create()
    {
        // Este método se usa si tienes una vista separada para crear, 
        // pero como usas modal en index, quizás no lo uses mucho.
        $empleados = Empleado::all();
        $alumnos = Alumno::all();
        return view('agenda.create', compact('empleados', 'alumnos'));
    }

    public function store(Request $request)
    {
        // 1. Validaciones
        $validated = $request->validate([
            'rfc_emp' => 'required|exists:empleados,rfc',
            'rfc_cliente' => 'required|exists:alumnos,rfc',
            'fecha' => 'required|date',
            'hora' => 'required',
            'fecha_pago' => 'required|date',
            'actividad' => 'required|in:EXAMEN,LECCIÓN',
            'km_recorridos' => 'nullable|integer',
            'exam_teo' => 'nullable|integer|between:0,100',
            'exam_prac' => 'nullable|integer|between:0,100',
            'notas' => 'nullable|string|max:50',
            'notas_resultado' => 'nullable|string|max:50',
        ]);

        // 2. Validar disponibilidad (Manual para mejor UX)
        $existe = Agenda::where('fecha', $validated['fecha'])
                        ->where('hora', $validated['hora'])
                        ->where('rfc_emp', $validated['rfc_emp'])
                        ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El instructor ya tiene una cita en ese horario.');
        }

        // 3. Validar Pago Existente
        $pagoExiste = Pago::where('rfc_cliente', $validated['rfc_cliente'])
                          ->where('fecha_pago', $validated['fecha_pago'])
                          ->exists();
        
        if (!$pagoExiste) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No existe un pago registrado para este alumno en la fecha indicada.');
        }

        // 4. Crear
        try {
            Agenda::create($validated);
            return redirect()->route('agenda.index')->with('success', 'Cita agendada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    // ✅ CORRECCIÓN: Ahora recibe solo $id
    public function update(Request $request, $id)
    {
        // Validación
        $validated = $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'actividad' => 'required|in:EXAMEN,LECCIÓN',
            'km_recorridos' => 'nullable|integer',
            'exam_teo' => 'nullable|integer|between:0,100',
            'exam_prac' => 'nullable|integer|between:0,100',
            'notas' => 'nullable|string|max:50',
            'notas_resultado' => 'nullable|string|max:50',
            // Si permites editar fecha_pago/cliente, agrégalos aquí
            'fecha_pago' => 'required|date', 
            'rfc_cliente' => 'required|exists:alumnos,rfc',
        ]);

        try {
            // Verificar pago nuevamente si cambió fecha o cliente
            $pagoExiste = Pago::where('rfc_cliente', $validated['rfc_cliente'])
                             ->where('fecha_pago', $validated['fecha_pago'])
                             ->exists();
            
            if (!$pagoExiste) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No existe un pago para este alumno en la fecha indicada.');
            }

            // ✅ Buscar por ID
            $agenda = Agenda::findOrFail($id);
            $agenda->update($validated);
            
            return redirect()->route('agenda.index')
                ->with('success', 'Cita actualizada correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // ✅ CORRECCIÓN: Ahora recibe solo $id
    public function destroy($id)
    {
        try {
            // ✅ Buscar por ID y eliminar
            $agenda = Agenda::findOrFail($id);
            $agenda->delete();
            
            return redirect()->route('agenda.index')
                ->with('success', 'Cita eliminada correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
    
    // Método auxiliar para obtener pagos de un alumno por AJAX
    public function getPagosByAlumno($rfc)
    {
        $pagos = Pago::where('rfc_cliente', $rfc)
                    ->orderBy('fecha_pago', 'desc')
                    ->get();
        
        return response()->json($pagos);
    }
}