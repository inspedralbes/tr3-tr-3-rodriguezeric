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

    public function sendEmail(Request $request)
    {
        // Obtén el ID de la entrada desde la solicitud
        $entradaId = $request->entrada_id;

        // Obtén la entrada desde la base de datos utilizando el ID
        $entrada = Entrada::find($entradaId);

        if (!$entrada) {
            return response()->json(['message' => 'Entrada no encontrada'], 404);
        }

        // Obtén el correo electrónico del destinatario desde la solicitud
        $correoDestinatario = $request->correoElectronico;

        // Prepara el contenido del correo electrónico
        $subject = 'Detalles de la entrada';
        $message = "Detalles de la entrada:\n\n";
        $message .= "ID de sesión: " . $entrada->session_id . "\n";
        $message .= "Título de la película: " . $entrada->movie_title . "\n";
        $message .= "Asientos seleccionados: " . $entrada->selected_seats . "\n";
        $message .= "Monto total: " . $entrada->total_amount . "\n";

        // Envía el correo electrónico
        $headers = 'From: a22erirodnos@inspedralbes.cat' . "\r\n" .
                   'Reply-To: a22erirodnos@inspedralbes.cat' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        mail($correoDestinatario, $subject, $message, $headers);

        return response()->json(['message' => 'Email enviado con éxito'], 200);
    }

    public function index() {
        return Entrada::all();
    }
}
