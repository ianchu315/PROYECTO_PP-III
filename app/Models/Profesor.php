<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function presidentes(){
        return $this->belongsTo(Presidente::class);
    }

    // Cuenta de login (guard "usuarios", rol profesor) vinculada a este
    // registro de mesas, para no tener que cargar los datos a mano.
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
