<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SessioController;

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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PeliculaController;

Route::get('/peliculas', [PeliculaController::class, 'index']);
Route::get('/peliculas/{id}', [PeliculaController::class, 'show']);


Route::get('/sesiones', [SessioController::class, 'index']);
Route::get('/sesiones/{id}', [SessioController::class, 'show']);


// Añade más rutas según necesites
