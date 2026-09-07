<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePagoRequest;

class PagoController extends Controller
{
    public function index()
    {
        Credito::actualizarVencidos();

        $pagos = Pago::with('credito.cliente')
            ->orderByDesc('fecha_pago')
            ->get();

        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        Credito::actualizarVencidos();
        // Solo créditos que todavía tengan saldo pendiente
        $creditos = Credito::with('cliente')
            ->where('saldo', '>', 0)
            ->whereIn('estado', ['activo', 'vencido'])
            ->orderBy('fecha_vencimiento')
            ->get();

        return view('pagos.create', compact('creditos'));
    }
    public function store(StorePagoRequest $request)
    {
        $datos = $request->validated();

        try {
            DB::transaction(function () use ($datos) {

                $credito = Credito::where('id', $datos['credito_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                // No aceptar pagos de créditos ya pagados
                if ($credito->estado === 'pagado' || $credito->saldo <= 0) {
                    throw new \Exception(
                        'Este crédito ya se encuentra pagado.'
                    );
                }

                // El pago no puede superar el saldo pendiente
                if ($datos['monto'] > $credito->saldo) {
                    throw new \Exception(
                        'El monto del pago no puede ser mayor al saldo pendiente.'
                    );
                }

                // Registrar el pago
                Pago::create([
                    'credito_id' => $credito->id,
                    'fecha_pago' => $datos['fecha_pago'],
                    'monto' => $datos['monto'],
                    'referencia' => $datos['referencia'] ?? null,
                    'observaciones' => $datos['observaciones'] ?? null,
                ]);

                // Restar el pago al saldo
                $nuevoSaldo = $credito->saldo - $datos['monto'];

                // Evitar pequeños valores negativos
                if ($nuevoSaldo < 0.01) {
                    $nuevoSaldo = 0;
                }

                $credito->saldo = $nuevoSaldo;

                // Si ya no debe nada, marcar como pagado
                if ($nuevoSaldo == 0) {
                    $credito->estado = 'pagado';
                }

                $credito->save();
            });

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'monto' => $e->getMessage()
                ])
                ->withInput();
        }

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }
}