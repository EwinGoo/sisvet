<?php

use App\Http\Controllers\Backend\PropietarioController;
use App\Http\Controllers\Backend\MascotaController;
// use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Route;


/* init::Rutas del sistema de administración*/

// Route::get('/test', [TestingController::class, 'index'])->name('/test');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Route::resource('admin/persona', PersonaController::class)->middleware(['auth'])->names('admin-persona');

// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::resource('persona', PersonaController::class)->names('admin-persona');
// });
Route::prefix('admin')->group(function () {
    Route::resource('propietario', PropietarioController::class)->names('admin-propietario');
    Route::resource('mascota', MascotaController::class)->names('admin-mascota');
});

/* end::Rutas del sistema de administración*/
