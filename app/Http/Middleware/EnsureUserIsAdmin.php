<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está logueado y si NO es admin
        // Usamos el método esAdmin() que ya tienes en tu modelo User
        if (Auth::check() && !Auth::user()->esAdmin()) {
            // Si no es admin, abortamos con error 403 (Prohibido) o redirigimos
            abort(403, 'ACCESO DENEGADO: Se requieren permisos de Administrador.');
        }

        return $next($request);
    }
}