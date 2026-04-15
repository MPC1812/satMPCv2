<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usamos Eloquent para crear los registros
        // Esto activará automáticamente los campos created_at y updated_at
        Role::create(['nombre' => 'Admin']);
        Role::create(['nombre' => 'Técnico']);
    }
}

