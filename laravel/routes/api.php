<?php

use App\Http\Controllers\SessioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\EntradaController;


Route::get('/peliculas', [PeliculaController::class, 'index']);
Route::get('/peliculas/{id}', [PeliculaController::class, 'show']);

Route::get('/sesiones', [SessioController::class, 'index']);
Route::get('/sesiones/{id}', [SessioController::class, 'show']);

Route::post('/entrada', [EntradaController::class, 'store']);
Route::get('/entradas', [EntradaController::class, 'index']);
Route::post('/entradas/{id}/enviar-correo', [EntradaController::class, 'sendEmail']);



