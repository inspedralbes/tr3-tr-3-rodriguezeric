<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entradas';

    protected $fillable = ['session_id', 'movie_title', 'selected_seats', 'total_amount'];

    public function session()
    {
        return $this->belongsTo(Sessio::class, 'session_id');
    }
}
