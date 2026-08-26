<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'estados';

    // Permitir asignación masiva del campo 'tipo'
    protected $fillable = ['tipo'];

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
