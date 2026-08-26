<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardar extends Model
{
    protected $table = 'ofertas_guardadas';

    protected $fillable = ['usuario_id', 'oferta_id'];
}
