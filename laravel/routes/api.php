<?php

use App\Http\Controllers\SessioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CorreoController; 



Route::get('/peliculas', [PeliculaController::class, 'index']);
Route::get('/peliculas/{id}', [PeliculaController::class, 'show']);
Route::post('/crear-pelicula', [PeliculaController::class, 'store']);

Route::get('/sesiones', [SessioController::class, 'index']);
Route::get('/sesiones/{id}', [SessioController::class, 'show']);
Route::post('/crear-sessio', [SessioController::class, 'store']);
Route::put('/modificar-sessio/{id}', [SessioController::class, 'update']);
Route::delete('/eliminar-sessio/{id}', [SessioController::class, 'destroy']);

Route::post('/entrada', [EntradaController::class, 'store']);
Route::get('/entradas', [EntradaController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']);
Route::post('/enviar-correo', [CorreoController::class, 'enviarCorreo']);



