<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller
{

    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfc'          => 'required|string|max:13|unique:alumnos,rfc',
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'nullable|string|max:255',
            'fecha_nac'    => 'required|date',
            'calle'        => 'required|string|max:255',
            'numero'       => 'required|string|max:50',
            'colonia'      => 'required|string|max:255',
            'alcaldia'     => 'required|string|max:255',
            'permiso'      => 'required|in:SI,NO',
            'correo'       => 'required|email|max:255',
            'observaciones'=> 'nullable|string|max:1000',
        ]);

        Alumno::create([
            'rfc'          => $request->rfc,
            'nombre'       => $request->nombre,
            'apellido_p'   => $request->apellido_p,
            'apellido_m'   => $request->apellido_m,
            'fecha_nac'    => $request->fecha_nac,
            'calle'        => $request->calle,
            'numero'       => $request->numero,
            'colonia'      => $request->colonia,
            'alcaldia'     => $request->alcaldia,
            'permiso'      => $request->permiso,
            'observaciones'=> $request->observaciones,
            'correo'       => $request->correo,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno agregado correctamente.');
    }


    public function update(Request $request, $rfc)
    {
        $alumno = Alumno::where('rfc', $rfc)->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'nullable|string|max:255',
            'fecha_nac'    => 'required|date',
            'calle'        => 'required|string|max:255',
            'numero'       => 'required|string|max:50',
            'colonia'      => 'required|string|max:255',
            'alcaldia'     => 'required|string|max:255',
            'permiso'      => 'required|in:SI,NO',
            'correo'       => 'required|email|max:255',
            'observaciones'=> 'nullable|string|max:1000',
        ]);

        $alumno->update([
            'nombre'       => $request->nombre,
            'apellido_p'   => $request->apellido_p,
            'apellido_m'   => $request->apellido_m,
            'fecha_nac'    => $request->fecha_nac,
            'calle'        => $request->calle,
            'numero'       => $request->numero,
            'colonia'      => $request->colonia,
            'alcaldia'     => $request->alcaldia,
            'permiso'      => $request->permiso,
            'correo'       => $request->correo,
            'observaciones'=> $request->observaciones,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }


    public function destroy($rfc)
    {
        $alumno = Alumno::where('rfc', $rfc)->firstOrFail();
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
