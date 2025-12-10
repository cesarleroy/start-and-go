<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpleadoController;

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


Route::resource('empleados', EmpleadoController::class);

require __DIR__.'/auth.php';
