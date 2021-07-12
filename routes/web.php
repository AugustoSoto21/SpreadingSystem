<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\AgenciasController;
use App\Http\Controllers\FuentesController;
use App\Http\Controllers\DeliverysController;
use App\Http\Controllers\ClientesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware('guest')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/estados',EstadosController::class);
Route::resource('/partidos',PartidosController::class);
Route::resource('/zonas',ZonasController::class);
Route::resource('/agencias',AgenciasController::class);
Route::resource('/fuentes',FuentesController::class);
Route::resource('/deliverys',DeliverysController::class);
Route::resource('/clientes',ClientesController::class);
