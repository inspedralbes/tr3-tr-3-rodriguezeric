<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entradas';

    protected $fillable = ['id_sesion', 'id_butaca', 'precio'];

    public function sesion()
    {
        return $this->belongsTo(Sessio::class, 'id_sesion');
    }
}
