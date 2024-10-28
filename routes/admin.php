<?php

use App\Http\Controllers\Backend\PropietarioController;
use App\Http\Controllers\Backend\MascotaController;
use App\Http\Controllers\Backend\Tienda\ClienteController;
use App\Http\Controllers\Backend\Tienda\InventarioController;
use App\Http\Controllers\Backend\Tienda\ProductoController;
use App\Http\Controllers\Backend\Tienda\VentaController;
use App\Http\Controllers\Backend\UsuarioController;
// use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Route;


/* init::Rutas del sistema de administración*/

// Route::get('/test', [TestingController::class, 'index'])->name('/test');
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Route::resource('admin/persona', PersonaController::class)->middleware(['auth'])->names('admin-persona');

// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::resource('persona', PersonaController::class)->names('admin-persona');
// });
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PropietarioController::class, 'index'])->name('dashboard');

    Route::middleware(['role:administrador'])->group(function () {
        Route::resource('usuario', UsuarioController::class)->names('admin-usuario');
        Route::post('/change-state-user', [UsuarioController::class, 'changeStatus'])->name('change-state');
        Route::get('/usuario/{id}/image', [UsuarioController::class, 'getImage'])->name('admin-usuario.get-image');
    });
    Route::middleware(['role:administrador,medico'])->group(function () {

        Route::resource('propietario', PropietarioController::class)->names('admin-propietario');
        Route::resource('mascota', MascotaController::class)->names('admin-mascota');

        Route::prefix('mascota')->group(function () {
            Route::post('/anamnesis', [MascotaController::class, 'anamnesisUpdate']);
            Route::post('/examen', [MascotaController::class, 'examenSave']);
            Route::post('/sintomas', [MascotaController::class, 'handleHistorialData']);
            Route::post('/diagnostico', [MascotaController::class, 'handleHistorialData']);
            Route::post('/tratamiento', [MascotaController::class, 'handleHistorialData']);
            Route::post('/evolucion', [MascotaController::class, 'handleHistorialData']);
        });
        Route::post('/mascota/historial', [MascotaController::class, 'historialClinicoSave']);
        Route::get('/mascota/{id}/historial', [MascotaController::class, 'historialIndex'])->name('admin-mascota.historial.index');
        Route::get('/mascota/historiales/{id}', [MascotaController::class, 'getAllHistorial']);
        Route::get('/mascota/historial/{id}/data', [MascotaController::class, 'getFullDataHistorial']);
    });

    Route::middleware(['role:administrador,vendedor'])->group(function () {
        Route::resource('inventario', InventarioController::class)->names('admin-inventario');
        Route::resource('cliente', ClienteController::class)->names('admin-cliente');
        Route::resource('producto', ProductoController::class)->names('admin-producto');
        Route::resource('venta', VentaController::class)->names('admin-venta');
    });
});


/* end::Rutas del sistema de administración*/