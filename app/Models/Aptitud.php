<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aptitud extends Model
{
    use HasFactory;


    protected $table = 'aptitudes';
    protected $fillable = ['usuario_id', 'aptitud'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
