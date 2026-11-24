<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAlumno
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'alumno') {
            abort(403, 'Acceso exclusivo para alumnos registrados en Start & Go.');
        }

        return $next($request);
    }
}