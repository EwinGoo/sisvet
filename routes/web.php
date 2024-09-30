<?php

use App\Http\Controllers\Backend\PropietarioController;
use App\Http\Controllers\Backend\Reportes\TestChasideReport;
use App\Http\Controllers\Backend\Reportes\Dashboard;
use App\Http\Controllers\Frontend\ChasideController;
use App\Http\Controllers\Frontend\InteligenciaController;
use App\Http\Controllers\Frontend\TestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController as Test;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');
Route::get('/', function () {
    return redirect()->action([PropietarioController::class, 'index']);
})->middleware('auth');

require __DIR__ . '/auth.php';
