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

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dia' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'pelicula_id' => 'required|integer|exists:peliculas,id'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Error en la validación', 'errors' => $e->errors()], 400);
        }

        // Crear la sesión en la base de datos
        $session = new Sessio();
        $session->dia = $request->dia;
        $session->hora = $request->hora;
        $session->pelicula_id = $request->pelicula_id;
        $session->save();

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Sesión creada con éxito', 'session' => $session], 201);
    }

}