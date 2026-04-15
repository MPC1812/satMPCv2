<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@satmpc.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'activo' => true,
        ]);

        User::create([
            'name' => 'Técnico Taller',
            'email' => 'tecnico@satmpc.com',
            'password' => Hash::make('tecnico123'),
            'role_id' => 2,
            'activo' => true,
        ]);
    }
}

