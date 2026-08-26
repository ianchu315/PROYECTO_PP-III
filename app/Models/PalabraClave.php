<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalabraClave extends Model
{
    use HasFactory;
    protected $table = 'palabras_claves';
    protected $fillable = [
        'oferta_id',
        'palabra',
    ];
}
