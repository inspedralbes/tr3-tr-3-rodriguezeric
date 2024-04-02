<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Valida los datos de inicio de sesión
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // El usuario ha sido autenticado
            return response()->json(['message' => 'Inicio de sesión exitoso'], 200);
        } else {
            // La autenticación falló
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }
}
