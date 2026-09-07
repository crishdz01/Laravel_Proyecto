<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeguridadClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_no_puede_ver_comprobante_de_otro_cliente(): void
    {
        // Cliente 1 con usuario
        $usuarioCliente1 = User::factory()->create([
            'rol' => 'cliente',
        ]);

        $cliente1 = Cliente::create([
            'usuario_id' => $usuarioCliente1->id,
            'nombres' => 'Carlos',
            'apellidos' => 'Hernandez',
            'documento_identidad' => 'SEG-001',
            'telefono' => '70000001',
            'correo' => 'carlos@test.com',
            'direccion' => 'La Paz',
            'estado' => 'activo',
        ]);

        // Cliente 2 con usuario
        $usuarioCliente2 = User::factory()->create([
            'rol' => 'cliente',
        ]);

        $cliente2 = Cliente::create([
            'usuario_id' => $usuarioCliente2->id,
            'nombres' => 'Ana',
            'apellidos' => 'Martinez',
            'documento_identidad' => 'SEG-002',
            'telefono' => '70000002',
            'correo' => 'ana@test.com',
            'direccion' => 'San Salvador',
            'estado' => 'activo',
        ]);

        // Crédito perteneciente al cliente 2
        $creditoCliente2 = Credito::create([
            'cliente_id' => $cliente2->id,
            'fecha_otorgamiento' => now()->toDateString(),
            'monto' => 1000,
            'tasa_interes' => 10,
            'plazo' => 6,
            'total_credito' => 1100,
            'saldo' => 900,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);

        // Pago perteneciente al crédito del cliente 2
        $pagoCliente2 = Pago::create([
            'credito_id' => $creditoCliente2->id,
            'fecha_pago' => now()->toDateString(),
            'monto' => 200,
            'referencia' => 'SEGURIDAD-001',
            'observaciones' => 'Pago cliente 2',
        ]);

        // Cliente 1 intenta ver el comprobante del cliente 2
        $response = $this->actingAs($usuarioCliente1)
            ->get(route('comprobantes.show', $pagoCliente2));

        $response->assertStatus(403);
    }
    public function test_cliente_puede_ver_su_propio_comprobante(): void
    {
        $usuarioCliente = User::factory()->create([
            'rol' => 'cliente',
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $usuarioCliente->id,
            'nombres' => 'Luis',
            'apellidos' => 'Ramirez',
            'documento_identidad' => 'SEG-003',
            'telefono' => '70000003',
            'correo' => 'luis@test.com',
            'direccion' => 'Zacatecoluca',
            'estado' => 'activo',
        ]);

        $credito = Credito::create([
            'cliente_id' => $cliente->id,
            'fecha_otorgamiento' => now()->toDateString(),
            'monto' => 1000,
            'tasa_interes' => 10,
            'plazo' => 6,
            'total_credito' => 1100,
            'saldo' => 900,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);

        $pago = Pago::create([
            'credito_id' => $credito->id,
            'fecha_pago' => now()->toDateString(),
            'monto' => 200,
            'referencia' => 'SEGURIDAD-002',
            'observaciones' => 'Pago propio',
        ]);

        $response = $this->actingAs($usuarioCliente)
            ->get(route('comprobantes.show', $pago));

        $response->assertStatus(200);

        $response->assertSee('SEGURIDAD-002');
    }
}