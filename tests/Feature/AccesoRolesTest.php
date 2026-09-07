<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;

class AccesoRolesTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_no_puede_entrar_al_panel_administrador(): void
    {
        $cliente = User::factory()->create([
            'rol' => 'cliente',
        ]);

        $response = $this->actingAs($cliente)
            ->get('/admin');

        $response->assertStatus(403);
    }

    public function test_empleado_no_puede_entrar_al_panel_administrador(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $response = $this->actingAs($empleado)
            ->get('/admin');

        $response->assertStatus(403);
    }

    public function test_administrador_puede_entrar_al_panel_administrador(): void
    {
        $administrador = User::factory()->create([
            'rol' => 'administrador',
        ]);

        $response = $this->actingAs($administrador)
            ->get('/admin');

        $response->assertStatus(200);
    }
    public function test_empleado_no_puede_desactivar_cliente(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Pedro',
            'apellidos' => 'Lopez',
            'documento_identidad' => 'ROL-001',
            'telefono' => '74444444',
            'correo' => 'pedro@test.com',
            'direccion' => 'San Salvador',
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($empleado)
            ->patch(route('clientes.desactivar', $cliente));

        $response->assertStatus(403);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'estado' => 'activo',
        ]);
    }
    public function test_administrador_puede_desactivar_cliente(): void
    {
        $administrador = User::factory()->create([
            'rol' => 'administrador',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Maria',
            'apellidos' => 'Ramirez',
            'documento_identidad' => 'ROL-002',
            'telefono' => '75555555',
            'correo' => 'maria@test.com',
            'direccion' => 'La Paz',
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($administrador)
            ->patch(route('clientes.desactivar', $cliente));

        $response->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'estado' => 'inactivo',
        ]);
    }
}