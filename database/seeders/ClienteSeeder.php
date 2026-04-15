<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder {
    public function run(): void {
        Cliente::create([
            'dni' => '12345678A',
            'nombre' => 'Mario',
            'apellidos' => 'Puertas Cortés',
            'telefono' => '615428580',
            'email' => 'mario@test.com'
        ]);
        Cliente::create([
            'dni' => '87654321B',
            'nombre' => 'Ana',
            'apellidos' => 'García López',
            'telefono' => '600112233',
            'email' => 'ana@test.com'
        ]);
    }
}

