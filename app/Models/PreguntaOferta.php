<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaOferta extends Model
{
    use HasFactory;
    
    protected $table = 'preguntas_ofertas';
    protected $fillable = [
        'oferta_id',
        'pregunta',
    ];
}
