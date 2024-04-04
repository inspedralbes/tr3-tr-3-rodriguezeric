<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra</title>
</head>
<body>
    <h2>Ticket de Compra</h2>
    <p><strong>Película:</strong> {{ $pelicula }}</p>
    <p><strong>Butacas:</strong></p>
    <ul>
        @foreach($butacasSeleccionadas as $butaca)
            <li>{{ $butaca }}</li>
        @endforeach
    </ul>
    <p><strong>Total:</strong> {{ $total }}€</p>
</body>
</html>
