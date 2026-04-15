<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $fillable = ['descripcion', 'precio', 'stock_actual'];

    // Un repuesto puede estar en muchos tickets
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_repuesto')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}

