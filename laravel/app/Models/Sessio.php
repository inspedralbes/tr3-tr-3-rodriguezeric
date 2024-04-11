<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessio extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'hora',
        'pelicula_id', // Asegúrate de tener el campo de la clave foránea en fillable
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'pelicula_id'); // Ajusta el nombre de la clase y la columna de la clave foránea si es necesario
    }
    
}

