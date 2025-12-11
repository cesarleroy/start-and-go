<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AyudaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PagosController;
use Illuminate\Support\Facades\Gate; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    return view('welcome');
});

// --- RUTA DE INICIO (Verificada) ---
Route::get('/inicio', function () {
    return view('inicio');
})->middleware(['auth', 'verified'])->name('inicio');


// =========================================================================
// 🔒 GRUPO DE ADMINISTRACIÓN (Solo usuarios con rol 'admin')
// =========================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // 1. Gestión de Empleados (CRUD Completo)
    Route::resource('empleados', EmpleadoController::class);

    // 2. Reportes y Estado de Cuenta
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/estado-cuenta', [ReporteController::class, 'estadoCuenta'])->name('reportes.estado_cuenta');

    // (Opcional) Ruta de prueba para verificar acceso admin
    Route::get('/admin-panel', function () {
        return "Bienvenido al Panel de Admin (Acceso Correcto)";
    });
});


// =========================================================================
// 👤 GRUPO GENERAL (Usuarios autenticados: Recepcionistas, Admins, etc.)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // --- Perfil de Usuario ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Sistema de Ayuda ---
    Route::get('/ayuda', [AyudaController::class, 'index'])->name('ayuda.index');

    // --- Gestión de Alumnos ---
    Route::resource('alumnos', AlumnoController::class);
    Route::post('/alumnos/store', [AlumnoController::class, 'store'])->name('alumnos.store');
    // Ruta específica para eliminar (aunque resource ya la trae, la mantenemos por seguridad si la usas así)
    Route::delete('/alumnos/{alumno}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
    Route::post('alumnos/credencial', [AlumnoController::class, 'generarCredencial'])->name('alumnos.credencial');

    // --- Gestión de Agenda ---
    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('agenda/{id}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('agenda/{id}', [AgendaController::class, 'update'])->name('agenda.update');
    
    // CORRECCIÓN: Usamos {id} para eliminar, coincidiendo con tu controlador y vista
    Route::delete('agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    
    // AJAX para obtener pagos
    Route::get('agenda/pagos/{rfc}', [AgendaController::class, 'getPagosByAlumno'])->name('agenda.pagos');

    // --- Gestión de Pagos ---
    Route::get('pagos', [PagosController::class, 'index'])->name('pagos.index');
    Route::get('pagos/create', [PagosController::class, 'create'])->name('pagos.create');
    Route::post('pagos', [PagosController::class, 'store'])->name('pagos.store');
    // Pagos usa llave compuesta en URL
    Route::get('pagos/{rfc_cliente}/{fecha_pago}/edit', [PagosController::class, 'edit'])->name('pagos.edit');
    Route::put('pagos/{rfc_cliente}/{fecha_pago}', [PagosController::class, 'update'])->name('pagos.update');
    Route::delete('pagos/{rfc_cliente}/{fecha_pago}', [PagosController::class, 'destroy'])->name('pagos.destroy');
    Route::get('pagos/precio/{tipo}', [PagosController::class, 'getPrecioContratacion'])->name('pagos.precio');

    // --- Rutas de Prueba de Roles (Opcionales, puedes borrarlas si ya no las usas) ---
    Route::get('/recepcion', function () {
        return "Bienvenido, Recepcionista";
    });
});

require __DIR__.'/auth.php';