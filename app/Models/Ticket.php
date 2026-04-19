<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['cliente_id', 'equipo', 'averia', 'notas_tecnicas', 'estado'];

    // Un ticket pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Un ticket puede tener muchos repuestos (Tabla pivote ticket_repuesto)
    public function repuestos()
    {
        return $this->belongsToMany(Repuesto::class, 'ticket_repuesto')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}

