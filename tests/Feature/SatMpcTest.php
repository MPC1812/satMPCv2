<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class SatMpcTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('roles')->insert([
            ['id' => 1, 'nombre' => 'admin'],
            ['id' => 2, 'nombre' => 'tecnico'],
        ]);
    }

    /** @test */
    public function test_un_usuario_no_autenticado_no_puede_ver_el_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_el_administrador_puede_iniciar_sesion()
    {
        // Creamos el usuario asegurando que el password sea 'password'
        $user = User::factory()->create([
            'email' => 'admin@satmpc.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'activo' => true
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@satmpc.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(); // Verificamos que redirige a alguna parte
    }

    /** @test */
    public function test_el_buscador_publico_de_tickets_funciona()
    {
        $clienteId = DB::table('clientes')->insertGetId([
            'dni' => '12345678Z', 'nombre' => 'Test', 'apellidos' => 'User', 'telefono' => '600111222'
        ]);

        // Añadimos created_at y updated_at para evitar el error de format()
        DB::table('tickets')->insert([
            'codigo' => 'SAT-TEST',
            'cliente_id' => $clienteId,
            'equipo' => 'Laptop',
            'averia' => 'Error',
            'estado' => 'Recibido',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $response = $this->get(route('tickets.consulta', ['codigo' => 'SAT-TEST']));
        $response->assertStatus(200);
        $response->assertSee('SAT-TEST');
    }

    /** @test */
    public function test_un_tecnico_no_puede_acceder_a_la_gestion_de_usuarios()
    {
        $tecnico = User::factory()->create(['role_id' => 2, 'activo' => true]);

        $response = $this->actingAs($tecnico)->get(route('admin.usuarios'));
        $response->assertRedirect(); // Verificamos que redirige a alguna parte (puede ser login o una página de error)
    }

    /** @test */
    public function test_el_sistema_valida_formatos_correctos_al_crear_usuario_admin()
    {
        $admin = User::factory()->create(['role_id' => 1, 'activo' => true]);

        // Enviamos datos vacíos a la ruta de guardado de usuarios
        $response = $this->actingAs($admin)->post(route('admin.usuarios.store'), [
            'name' => '', 
            'email' => 'no-email'
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function test_un_usuario_bloqueado_no_puede_iniciar_sesion()
    {
        User::factory()->create([
            'email' => 'bloqueado@satmpc.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'activo' => false
        ]);

        $response = $this->post(route('login'), [
            'email' => 'bloqueado@satmpc.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }
}



