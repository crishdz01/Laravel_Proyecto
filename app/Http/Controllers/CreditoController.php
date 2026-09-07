<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StoreCreditoRequest;

class CreditoController extends Controller
{
    public function index(Request $request)
    {
        Credito::actualizarVencidos();    

        $estado = $request->input('estado');

        $creditos = Credito::with('cliente')
            ->when($estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->orderByDesc('fecha_otorgamiento')
            ->get();

        return view('creditos.index', compact('creditos', 'estado'));
    }
    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')
            ->orderBy('nombres')
            ->get();

        return view('creditos.create', compact('clientes'));
    }
    public function store(StoreCreditoRequest $request)
    {
        $datos = $request->validated();

        $cliente = Cliente::findOrFail($datos['cliente_id']);

        if ($cliente->estado !== 'activo') {
            return back()
                ->withErrors([
                    'cliente_id' =>
                        'No se puede registrar un crédito para un cliente inactivo.'
                ])
                ->withInput();
        }

        $interes = $datos['monto'] * ($datos['tasa_interes'] / 100);

        $totalCredito = $datos['monto'] + $interes;

        $fechaVencimiento = Carbon::parse($datos['fecha_otorgamiento'])
            ->add((int) $datos['plazo'], 'month');

        Credito::create([
            'cliente_id' => $datos['cliente_id'],
            'fecha_otorgamiento' => $datos['fecha_otorgamiento'],
            'monto' => $datos['monto'],
            'tasa_interes' => $datos['tasa_interes'],
            'plazo' => $datos['plazo'],
            'total_credito' => $totalCredito,
            'saldo' => $totalCredito,
            'fecha_vencimiento' => $fechaVencimiento,
            'estado' => 'activo',
        ]);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito registrado correctamente.');
    }
}