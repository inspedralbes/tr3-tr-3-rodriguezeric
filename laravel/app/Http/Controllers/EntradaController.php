<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function store(Request $request)
    {
        // Valida los datos de la entrada
        $request->validate([
            'id_sesion' => 'required|exists:sessios,id',
            'id_butaca' => 'required|exists:butacas,id',
            'precio' => 'required|numeric|min:0',
        ]);

        // Crea una nueva entrada
        $entrada = new Entrada([
            'id_sesion' => $request->id_sesion,
            'id_butaca' => $request->id_butaca,
            'precio' => $request->precio,
        ]);

        // Guarda la entrada en la base de datos
        $entrada->save();

        // Retorna una respuesta exitosa
        return response()->json(['message' => 'Entrada creada exitosamente'], 201);
    }
}
