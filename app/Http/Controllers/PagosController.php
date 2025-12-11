<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Alumno;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagosController extends Controller
{
    public function index()
    {
        // Obtener pagos con relaciones
        $pagos = Pago::with(['alumno', 'contratacion'])
                    ->orderBy('fecha_pago', 'desc')
                    ->get();
        
        // Obtener alumnos para el select
        $alumnos = Alumno::select('rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        // Obtener tipos de contratación
        $contrataciones = Contratacion::orderBy('tipo_contratacion')->get();
        
        return view('pagos.index', compact('pagos', 'alumnos', 'contrataciones'));
    }

    public function create()
    {
        $alumnos = Alumno::select('rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        $contrataciones = Contratacion::orderBy('tipo_contratacion')->get();
        
        return view('pagos.create', compact('alumnos', 'contrataciones'));
    }

    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'rfc_cliente' => 'required|exists:alumnos,rfc',
            'fecha_pago' => 'required|date',
            'tipo_contratacion' => 'required|exists:contratacion,tipo_contratacion',
            'total_pago' => 'required|integer|min:0',
            'forma_pago' => 'required|in:DEBITO,CRÉDITO,EFECTIVO,TRANSFERENCIA',
            'reembolso' => 'nullable|boolean'
        ], [
            'rfc_cliente.exists' => 'El RFC del alumno no existe.',
            'tipo_contratacion.exists' => 'El tipo de contratación no existe.',
        ]);

        // Convertir checkbox a boolean
        $validated['reembolso'] = $request->has('reembolso') ? 1 : 0;

        try {
            // Verificar que no exista ya un pago con la misma llave primaria compuesta
            $pagoExistente = Pago::where('rfc_cliente', $validated['rfc_cliente'])
                                 ->where('fecha_pago', $validated['fecha_pago'])
                                 ->exists();
            
            if ($pagoExistente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ya existe un pago registrado para este alumno en esta fecha.');
            }

            Pago::create($validated);
            
            return redirect()->route('pagos.index')
                ->with('success', 'Pago registrado correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($rfc_cliente, $fecha_pago)
    {
        $pago = Pago::where('rfc_cliente', $rfc_cliente)
                   ->where('fecha_pago', $fecha_pago)
                   ->firstOrFail();
        
        $alumnos = Alumno::select('rfc', 'nombre', 'apellido_p', 'apellido_m')
                        ->orderBy('nombre')
                        ->get();
        
        $contrataciones = Contratacion::orderBy('tipo_contratacion')->get();
        
        return view('pagos.edit', compact('pago', 'alumnos', 'contrataciones'));
    }

    public function update(Request $request, $rfc_cliente, $fecha_pago)
    {
        $validated = $request->validate([
            'tipo_contratacion' => 'required|exists:contratacion,tipo_contratacion',
            'total_pago' => 'required|integer|min:0',
            'forma_pago' => 'required|in:DEBITO,CRÉDITO,EFECTIVO,TRANSFERENCIA',
            'reembolso' => 'nullable|boolean'
        ]);

        // Convertir checkbox a boolean
        $validated['reembolso'] = $request->has('reembolso') ? 1 : 0;

        try {
            $pago = Pago::where('rfc_cliente', $rfc_cliente)
                       ->where('fecha_pago', $fecha_pago)
                       ->firstOrFail();
            
            $pago->update($validated);
            
            return redirect()->route('pagos.index')
                ->with('success', 'Pago actualizado correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy($rfc_cliente, $fecha_pago)
    {
        try {
            $pago = Pago::where('rfc_cliente', $rfc_cliente)
                       ->where('fecha_pago', $fecha_pago)
                       ->firstOrFail();
            
            // Verificar si hay agendas asociadas
            $agendasAsociadas = DB::table('agenda')
                                  ->where('rfc_cliente', $rfc_cliente)
                                  ->where('fecha_pago', $fecha_pago)
                                  ->count();
            
            if ($agendasAsociadas > 0) {
                return redirect()->back()
                    ->with('error', "No se puede eliminar este pago porque tiene {$agendasAsociadas} cita(s) asociada(s).");
            }
            
            $pago->delete();
            
            return redirect()->route('pagos.index')
                ->with('success', 'Pago eliminado correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
    
    // Método auxiliar para obtener el precio de un tipo de contratación
    public function getPrecioContratacion($tipo)
    {
        $contratacion = Contratacion::where('tipo_contratacion', $tipo)->first();
        return response()->json(['precio' => $contratacion ? $contratacion->precio : 0]);
    }
}