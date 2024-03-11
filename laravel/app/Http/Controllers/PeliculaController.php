<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class PeliculaController extends Controller
{
    public function index() {
        return Pelicula::all();
    }

    public function show($id) {
        return Pelicula::find($id);
    }
    // Otros métodos según necesites

    
}

