<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AyudaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PagosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('inicio');
})->middleware(['auth', 'verified'])->name('inicio');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/estado-cuenta', [ReporteController::class, 'estadoCuenta'])->name('reportes.estado_cuenta');
});


// 4 rutas nuevas de prueba para los tipos de usuario
Route::get('/admin', function () {
    Gate::authorize('solo-admin');
    return "Bienvenido, Administrador";
})->middleware(['auth']);

Route::get('/recepcion', function () {
    Gate::authorize('solo-recepcionista');
    return "Bienvenido, Recepcionista";
})->middleware(['auth']);

Route::get('/panel-general', function () {
    Gate::authorize('admin-o-recepcionista');
    return "Acceso permitido";
})->middleware(['auth']);

//probar el admin
Route::get('/admin-panel', function () {
    Gate::authorize('solo-admin');
    return "Bienvenido Administrador";
})->middleware('auth');

Route::resource('alumnos', AlumnoController::class);

Route::post('/alumnos/store', [AlumnoController::class, 'store'])->name('alumnos.store');

Route::resource('empleados', EmpleadoController::class);

require __DIR__.'/auth.php';


// Sistema de Ayuda
Route::get('/ayuda', function () {
    return view('ayuda.index');
})->name('ayuda');

// Rutas para Agenda
Route::middleware(['auth'])->group(function () {

    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('agenda', [AgendaController::class, 'store'])->name('agenda.store');

    Route::put('agenda/{fecha}/{hora}/{rfc_emp}', [AgendaController::class, 'update'])
        ->name('agenda.update');

    Route::delete('agenda/{fecha}/{hora}/{rfc_emp}', [AgendaController::class, 'destroy'])
        ->name('agenda.destroy');

    Route::get('agenda/pagos/{rfc}', [AgendaController::class, 'getPagosByAlumno'])
        ->name('agenda.pagos');
});


// Rutas para Pagos
Route::middleware(['auth'])->group(function () {
    // Index y create usan las rutas normales
    Route::get('pagos', [PagosController::class, 'index'])->name('pagos.index');
    Route::get('pagos/create', [PagosController::class, 'create'])->name('pagos.create');
    Route::post('pagos', [PagosController::class, 'store'])->name('pagos.store');
    
    // Edit, update y destroy necesitan dos parámetros (llave compuesta)
    Route::get('pagos/{rfc_cliente}/{fecha_pago}/edit', [PagosController::class, 'edit'])->name('pagos.edit');
    Route::put('pagos/{rfc_cliente}/{fecha_pago}', [PagosController::class, 'update'])->name('pagos.update');
    Route::delete('pagos/{rfc_cliente}/{fecha_pago}', [PagosController::class, 'destroy'])->name('pagos.destroy');
    
    // Ruta auxiliar para obtener precio de contratación
    Route::get('pagos/precio/{tipo}', [PagosController::class, 'getPrecioContratacion'])
        ->name('pagos.precio');
});