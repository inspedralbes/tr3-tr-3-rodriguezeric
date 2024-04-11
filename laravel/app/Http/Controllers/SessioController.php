<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessio;
use App\Models\Entrada;

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

    public function show($id){
        $session = Sessio::with('pelicula')->find($id);
        if ($session) {
            return response()->json($session);
        } else {
            return response()->json(['message' => 'Sesión no encontrada'], 404);
        }
    }
    
    public function update(Request $request, $id){
        $session = Sessio::find($id);
        if ($session) {
            $validatedData = $request->validate([
                'dia' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'pelicula_id' => 'required|integer|exists:peliculas,id'
            ]);
    
            $session->dia = $request->dia;
            $session->hora = $request->hora;
            $session->pelicula_id = $request->pelicula_id;
            $session->save();
            
            return response()->json(['message' => 'Sesión modificada con éxito', 'session' => $session]);
        } else {
            return response()->json(['message' => 'Sesión no encontrada'], 404);
        }
    }

    public function destroy($id){
        $session = Sessio::find($id);
        if ($session) {
            $session->delete();
            return response()->json(['message' => 'Sesión eliminada con éxito']);
        } else {
            return response()->json(['message' => 'Sesión no encontrada'], 404);
        }
    }
    
    // Método para calcular el total recaudado por sesión
    public function calculateTotalRecaudado($id) {
        $session = Sessio::find($id);
        if ($session) {
            $totalRecaudado = Entrada::where('session_id', $id)->sum('total_amount');
            $session->total_recaudado = $totalRecaudado;
            $session->save();
            
            return response()->json(['message' => 'Total recaudado calculado y actualizado con éxito para la sesión '.$id]);
        } else {
            return response()->json(['message' => 'Sesión no encontrada'], 404);
        }
    }
}
