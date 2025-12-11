<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'rfc' => 'required|unique:empleados,rfc|max:13',
            'nombre' => 'required',
            'apellido_p' => 'required',
            'puesto' => 'required',
            'turno' => 'required',
            'fecha_nac' => 'required|date',
            'tel' => 'required|numeric|digits:10',
        ]);

        
        $descansos = isset($request->descansos) ? implode(',', $request->descansos) : '';

        
        Empleado::create([
            'rfc' => $request->rfc,
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,    
            'apellido_m' => $request->apellido_m,
            'puesto' => $request->puesto,
            'turno' => $request->turno,
            'descansos' => $descansos,
            'sexo' => $request->sexo,
            'fecha_nac' => $request->fecha_nac,
            'tel_personal' => $request->tel,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'colonia' => $request->colonia,
            'alcaldia' => $request->alcaldia,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado agregado correctamente.');
    }

    public function update(Request $request, $id)
    {
        
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            
        ]);

        $descansos = isset($request->descansos) ? implode(',', $request->descansos) : '';

        $empleado->update([
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'puesto' => $request->puesto,
            'turno' => $request->turno,
            'descansos' => $descansos,
            'sexo' => $request->sexo,
            'fecha_nac' => $request->fecha_nac,
            'tel_personal' => $request->tel,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'colonia' => $request->colonia,
            'alcaldia' => $request->alcaldia,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}