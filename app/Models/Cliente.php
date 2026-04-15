<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['dni', 'nombre', 'apellidos', 'telefono', 'email'];

    // Un cliente tiene muchos tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

