<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    use HasFactory;

    protected $table = 'modalidad_trabajos';

    protected $fillable = [
        'tipo',
    ];
    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
