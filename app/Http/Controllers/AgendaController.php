<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Empleado;
use App\Models\Alumno;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function index()
    {
        // Obtener agendas con relaciones
        $agendas = Agenda::with(['empleado', 'alumno'])
                        ->orderBy('fecha', 'desc')
                        ->orderBy('hora')
                        ->get();
        
        // Obtener empleados
        $empleados = Empleado::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                            ->orderBy('nombre')
                            ->get();
        
        // Obtener alumnos
        $alumnos = Alumno::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        return view('agenda.index', compact('agendas', 'empleados', 'alumnos'));
    }

    public function create()
    {
        $empleados = Empleado::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                            ->orderBy('nombre')
                            ->get();
        
        $alumnos = Alumno::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        // Obtener pagos disponibles
        $pagos = Pago::with('alumno')
                    ->orderBy('fecha_pago', 'desc')
                    ->get();
        
        return view('agenda.create', compact('empleados', 'alumnos', 'pagos'));
    }

    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'rfc_emp' => 'required|exists:empleados,rfc',
            'fecha' => 'required|date',
            'hora' => 'required',
            'rfc_cliente' => 'required|exists:alumnos,rfc',
            'fecha_pago' => 'required|date',
            'actividad' => 'required|in:EXAMEN,LECCIÓN',
            'exam_teo' => 'nullable|integer|between:0,100',
            'exam_prac' => 'nullable|integer|between:0,100',
            'km_recorridos' => 'nullable|integer|min:0',
            'notas' => 'nullable|string|max:50',
            'notas_resultado' => 'nullable|string|max:50'
        ], [
            'rfc_cliente.exists' => 'El RFC del alumno no existe.',
            'rfc_emp.exists' => 'El RFC del empleado no existe.',
        ]);

        try {
            // Verificar que exista el pago
            $pagoExiste = Pago::where('rfc_cliente', $validated['rfc_cliente'])
                             ->where('fecha_pago', $validated['fecha_pago'])
                             ->exists();
            
            if (!$pagoExiste) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No existe un pago para este alumno en la fecha indicada.');
            }

            Agenda::create($validated);
            
            return redirect()->route('agenda.index')
                ->with('success', 'Cita agregada correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        
        $empleados = Empleado::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                            ->orderBy('nombre')
                            ->get();
        
        $alumnos = Alumno::select('id', 'rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        $pagos = Pago::with('alumno')
                    ->where('rfc_cliente', $agenda->rfc_cliente)
                    ->orderBy('fecha_pago', 'desc')
                    ->get();
        
        return view('agenda.edit', compact('agenda', 'empleados', 'alumnos', 'pagos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rfc_emp' => 'required|exists:empleados,rfc',
            'fecha' => 'required|date',
            'hora' => 'required',
            'rfc_cliente' => 'required|exists:alumnos,rfc',
            'fecha_pago' => 'required|date',
            'actividad' => 'required|in:EXAMEN,LECCIÓN',
            'exam_teo' => 'nullable|integer|between:0,100',
            'exam_prac' => 'nullable|integer|between:0,100',
            'km_recorridos' => 'nullable|integer|min:0',
            'notas' => 'nullable|string|max:50',
            'notas_resultado' => 'nullable|string|max:50'
        ]);

        try {
            // Verificar que exista el pago
            $pagoExiste = Pago::where('rfc_cliente', $validated['rfc_cliente'])
                             ->where('fecha_pago', $validated['fecha_pago'])
                             ->exists();
            
            if (!$pagoExiste) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No existe un pago para este alumno en la fecha indicada.');
            }

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

    public function destroy($id)
    {
        try {
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