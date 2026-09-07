<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagoValidacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_pago_no_puede_ser_mayor_al_saldo_pendiente(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Carlos',
            'apellidos' => 'Hernandez',
            'documento_identidad' => 'TEST-001',
            'telefono' => '70000000',
            'correo' => 'cliente@test.com',
            'direccion' => 'San Salvador',
            'estado' => 'activo',
        ]);

        $credito = Credito::create([
            'cliente_id' => $cliente->id,
            'fecha_otorgamiento' => now()->toDateString(),
            'monto' => 1000,
            'tasa_interes' => 10,
            'plazo' => 6,
            'total_credito' => 1100,
            'saldo' => 500,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($empleado)
            ->post(route('pagos.store'), [
                'credito_id' => $credito->id,
                'fecha_pago' => now()->toDateString(),
                'monto' => 600,
                'referencia' => 'PRUEBA-001',
                'observaciones' => 'Pago de prueba',
            ]);

        $response->assertSessionHasErrors('monto');

        $this->assertDatabaseMissing('pagos', [
            'credito_id' => $credito->id,
            'monto' => 600,
        ]);

        $this->assertDatabaseHas('creditos', [
            'id' => $credito->id,
            'saldo' => 500,
            'estado' => 'activo',
        ]);
    }

    public function test_pago_valido_actualiza_el_saldo_correctamente(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Ana',
            'apellidos' => 'Martinez',
            'documento_identidad' => 'TEST-002',
            'telefono' => '71111111',
            'correo' => 'ana@test.com',
            'direccion' => 'La Paz',
            'estado' => 'activo',
        ]);

        $credito = Credito::create([
            'cliente_id' => $cliente->id,
            'fecha_otorgamiento' => now()->toDateString(),
            'monto' => 1000,
            'tasa_interes' => 10,
            'plazo' => 6,
            'total_credito' => 1100,
            'saldo' => 500,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($empleado)
            ->post(route('pagos.store'), [
                'credito_id' => $credito->id,
                'fecha_pago' => now()->toDateString(),
                'monto' => 200,
                'referencia' => 'PRUEBA-002',
                'observaciones' => 'Pago válido',
            ]);

        $response->assertRedirect(route('pagos.index'));

        $this->assertDatabaseHas('pagos', [
            'credito_id' => $credito->id,
            'monto' => 200,
            'referencia' => 'PRUEBA-002',
        ]);

        $this->assertDatabaseHas('creditos', [
            'id' => $credito->id,
            'saldo' => 300,
            'estado' => 'activo',
        ]);
    }
    public function test_pago_completo_marca_credito_como_pagado(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Luis',
            'apellidos' => 'Ramirez',
            'documento_identidad' => 'TEST-003',
            'telefono' => '72222222',
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
            'saldo' => 500,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($empleado)
            ->post(route('pagos.store'), [
                'credito_id' => $credito->id,
                'fecha_pago' => now()->toDateString(),
                'monto' => 500,
                'referencia' => 'PRUEBA-003',
                'observaciones' => 'Pago completo',
            ]);

        $response->assertRedirect(route('pagos.index'));

        $this->assertDatabaseHas('pagos', [
            'credito_id' => $credito->id,
            'monto' => 500,
        ]);

        $this->assertDatabaseHas('creditos', [
            'id' => $credito->id,
            'saldo' => 0,
            'estado' => 'pagado',
        ]);
    }
    public function test_credito_pagado_no_puede_recibir_otro_pago(): void
    {
        $empleado = User::factory()->create([
            'rol' => 'empleado',
        ]);

        $cliente = Cliente::create([
            'nombres' => 'Mario',
            'apellidos' => 'Lopez',
            'documento_identidad' => 'TEST-004',
            'telefono' => '73333333',
            'correo' => 'mario@test.com',
            'direccion' => 'San Vicente',
            'estado' => 'activo',
        ]);

        $credito = Credito::create([
            'cliente_id' => $cliente->id,
            'fecha_otorgamiento' => now()->toDateString(),
            'monto' => 1000,
            'tasa_interes' => 10,
            'plazo' => 6,
            'total_credito' => 1100,
            'saldo' => 0,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
            'estado' => 'pagado',
        ]);

        $response = $this->actingAs($empleado)
            ->post(route('pagos.store'), [
                'credito_id' => $credito->id,
                'fecha_pago' => now()->toDateString(),
                'monto' => 100,
                'referencia' => 'PRUEBA-004',
                'observaciones' => 'Pago inválido sobre crédito pagado',
            ]);

        $response->assertSessionHasErrors('monto');

        $this->assertDatabaseMissing('pagos', [
            'credito_id' => $credito->id,
            'monto' => 100,
        ]);

        $this->assertDatabaseHas('creditos', [
            'id' => $credito->id,
            'saldo' => 0,
            'estado' => 'pagado',
        ]);
    }
}
