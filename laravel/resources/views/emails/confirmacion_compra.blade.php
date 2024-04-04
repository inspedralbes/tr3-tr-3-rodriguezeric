<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
</head>
<body>
    <h2>¡Gracias por tu compra!</h2>
    <p>Aquí están los detalles de tu entrada:</p>
    <ul>
        <li><strong>Sesión:</strong> {{ $data['session_id'] }}</li>
        <li><strong>Título de la película:</strong> {{ $data['movie_title'] }}</li>
        <li><strong>Asientos seleccionados:</strong> {{ $data['selected_seats'] }}</li>
        <li><strong>Importe total:</strong> {{ $data['total_amount'] }}€</li>
        <li><strong>Correo electrónico:</strong> {{ $data['email'] }}</li>
    </ul>
    <p>¡Disfruta de la película!</p>
</body>
</html>
