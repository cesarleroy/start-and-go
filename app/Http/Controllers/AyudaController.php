<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AyudaController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        // Usar session() helper para manejar la bienvenida
        if (!session()->has('bienvenida_mostrada')) {
            session(['bienvenida_mostrada' => true]);
            $mostrarBienvenida = true;
        } else {
            $mostrarBienvenida = false;
        }

        return view('ayuda.index', [
            'usuario' => $usuario,
            'mostrarBienvenida' => $mostrarBienvenida
        ]);
    }
}