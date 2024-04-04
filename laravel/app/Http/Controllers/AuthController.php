<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    

    // Método para manejar el proceso de registro
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        // Validar los datos del formulario de registro
       

        

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
        ], 201);

        // Autenticar al usuario después del registro
        Auth::login($user);

        // Redirigir al usuario a una ubicación después del registro exitoso
        return redirect()->route('dashboard');
    }

    // Método para mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para manejar el proceso de inicio de sesión
    public function login(Request $request)
{
    // Validar los datos del formulario de inicio de sesión
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Verificar las credenciales del usuario
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Si las credenciales son válidas, retornar los datos del usuario
        return response()->json([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ], 200);
    }

    // Si las credenciales no son válidas, retornar un mensaje de error
    return response()->json(['error' => 'Credenciales inválidas'], 401);
}

    // Método para cerrar sesión
    public function logout()
    {
        Auth::logout();
    }

    public function user()
    {
        return Auth::all();
    }
}
