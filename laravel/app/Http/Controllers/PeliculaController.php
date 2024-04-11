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

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titol' => 'required|string',
                'duracio' => 'required|integer',
                'poster' => 'required|string',
                'sinopsis' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Error en la validación', 'errors' => $e->errors()], 400);
        }
        
        // Crear la película en la base de datos
        $pelicula = new Pelicula();
        $pelicula->titol = $request->titol;
        $pelicula->duracio = $request->duracio;
        $pelicula->poster = $request->poster;
        $pelicula->sinopsis = $request->sinopsis;
        $pelicula->save();

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Película creada con éxito', 'pelicula' => $pelicula], 201);
    }
}



