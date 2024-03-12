<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessio;

class SessioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sesiones = Sessio::with('pelicula')->get(); // Carga la relación con la película
        return response()->json($sesiones);
    }

    // Otros métodos del controlador...
}