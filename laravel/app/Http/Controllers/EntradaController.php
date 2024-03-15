<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'session_id' => 'required|integer|exists:sessions,id',
            'movie_title' => 'required|string',
            'selected_seats' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);

        $entrada = Entrada::create($validatedData);

        return response()->json(['message' => 'Entrada creada con éxito', 'data' => $entrada], 201);
    }
}
