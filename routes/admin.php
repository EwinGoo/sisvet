<?php

use App\Http\Controllers\Backend\HistorialClinicoController;
use App\Http\Controllers\Backend\PropietarioController;
use App\Http\Controllers\Backend\MascotaController;
use App\Http\Controllers\Backend\Reportes\HistorialClinicoReport;
use App\Http\Controllers\Backend\Tienda\ClienteController;
use App\Http\Controllers\Backend\Tienda\InventarioController;
use App\Http\Controllers\Backend\Tienda\ProductoController;
use App\Http\Controllers\Backend\Tienda\VentaController;
use App\Http\Controllers\Backend\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/* init::Rutas del sistema de administración*/

Route::get('/test', [TestController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Route::resource('admin/persona', PersonaController::class)->middleware(['auth'])->names('admin-persona');

// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::resource('persona', PersonaController::class)->names('admin-persona');
// });
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PropietarioController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:administrador'])->group(function () {
        Route::resource('usuario', UsuarioController::class)->names('admin-usuario');
        Route::post('/change-state-user', [UsuarioController::class, 'changeStatus'])->name('change-state');
        Route::get('/usuario/{id}/image', [UsuarioController::class, 'getImage'])->name('admin-usuario.get-image');
    });
    Route::middleware(['role:administrador,medico'])->group(function () {
        Route::resource('propietario', PropietarioController::class)->names('admin-propietario');
        Route::resource('mascota', MascotaController::class)->names('admin-mascota');
        Route::get('mascota/get-razas/{id}',  [MascotaController::class, 'getRazas']);

        Route::prefix('mascota')->group(function () {



            Route::get('/{id}/historial/reporte', [HistorialClinicoReport::class, 'index']);

        });

        Route::prefix('mascota/{id}/historial')->group(function () {
            Route::post('anamnesis', [HistorialClinicoController::class, 'anamnesisUpdate']);
            Route::post('examen', [HistorialClinicoController::class, 'examenSave']);
            Route::post('{option}', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('vacunas', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('sintomas', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('metodos_complementarios', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('diagnosticos_presuntivos', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('diagnosticos_definitivos', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('tratamiento', [HistorialClinicoController::class, 'handleHistorialData']);
            // Route::post('evolucion', [HistorialClinicoController::class, 'handleHistorialData']);

            Route::delete('{option}/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('examen/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('sintomas/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('metodos_complementarios/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('diagnosticos_presuntivos/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('diagnosticos_definitivos/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('tratamiento/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);
            // Route::delete('evolucion/{idReg}', [HistorialClinicoController::class, 'deleteHistorialData']);

        });
        Route::post('mascota/historial', [HistorialClinicoController::class, 'historialClinicoSave']);
        // Route::get('mascota/historiales/{id}', [HistorialClinicoController::class, 'getAllHistorial']);
        Route::get('mascota/{id}/historial', [HistorialClinicoController::class, 'historial'])->name('admin-mascota.historial.index');
        Route::get('mascota/{id}/historial/{option}', [HistorialClinicoController::class, 'historial']);

    });

    Route::middleware(['role:administrador,vendedor'])->group(function () {
        Route::resource('inventario', InventarioController::class)->names('admin-inventario');
        Route::get('inventario-reporte', [InventarioController::class, 'reporte'])->name('admin-inventario.reporte');
        Route::resource('cliente', ClienteController::class)->names('admin-cliente');
        Route::resource('producto', ProductoController::class)->names('admin-producto');
        Route::resource('venta', VentaController::class)->names('admin-venta');
    });
});


/* end::Rutas del sistema de administración*/
