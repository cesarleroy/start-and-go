<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $alumnos = Alumno::all();   // obtenemos todos los registros
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
        'rfc' => 'required|string|max:255',
        'nombre' => 'required|string|max:255',
        'apellido_paterno' => 'required|string|max:255',
        'apellido_materno' => 'nullable|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'calle' => 'required|string|max:255',
        'numero' => 'required|string|max:255',
        'colonia' => 'required|string|max:255',
        'alcaldia' => 'required|string|max:255',
        'permiso' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'observaciones' => 'nullable|string|max:1000',
    ]);

        // Crear un nuevo alumno
        Alumno::create([
            'rfc' => $request->rfc,
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'fecha_nac' => $request->fecha_nacimiento,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'colonia' => $request->colonia,
            'alcaldia' => $request->alcaldia,
            'permiso' => $request->permiso,
            'observaciones' => $request->observaciones,
            'correo' => $request->correo,
        ]);

        // Redireccionar con mensaje
        return redirect()->route('alumnos.index')->with('success', 'Alumno agregado con éxito');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
