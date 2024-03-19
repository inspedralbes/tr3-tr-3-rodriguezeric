<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'session_id' => 'required|integer|exists:sessios,id',
            'movie_title' => 'required|string',
            'selected_seats' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['message' => 'Error en la validación', 'errors' => $e->errors()], 400);
    }
        $entrada= new Entrada();
        $entrada->session_id = $request->session_id;
        $entrada->movie_title = $request->movie_title;
        $entrada->selected_seats = $request->selected_seats;
        $entrada->total_amount = $request->total_amount;
        $entrada->save();
        return response()->json(['message' => 'Entrada creada con éxito', 'entrada' => $entrada], 201);
        
    }
    public function index() {
        return Entrada::all();
    }
}
