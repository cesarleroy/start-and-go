<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
