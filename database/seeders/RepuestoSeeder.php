<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repuesto; // Importamos el modelo

class RepuestoSeeder extends Seeder
{
    public function run(): void
    {
        // Definimos los datos en un array
        $repuestos = [
            [
                'descripcion' => 'Disco SSD 500GB Crucial',
                'precio' => 45.50,
                'stock_actual' => 10,
            ],
            [
                'descripcion' => 'Memoria RAM 8GB DDR4',
                'precio' => 32.00,
                'stock_actual' => 15,
            ],
            [
                'descripcion' => 'Pantalla Portátil 15.6 LED',
                'precio' => 85.00,
                'stock_actual' => 5,
            ],
            [
                'descripcion' => 'Batería Compatible HP Pavilion',
                'precio' => 28.90,
                'stock_actual' => 8,
            ],
            [
                'descripcion' => 'Teclado Universal Negro USB',
                'precio' => 12.00,
                'stock_actual' => 20,
            ],
        ];

        // Insertamos cada repuesto usando Eloquent
        foreach ($repuestos as $dato) {
            Repuesto::create($dato);
        }
    }
}

