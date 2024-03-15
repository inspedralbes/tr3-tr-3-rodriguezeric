<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $fillable = ['session_id', 'movie_title', 'selected_seats', 'total_amount'];
}
