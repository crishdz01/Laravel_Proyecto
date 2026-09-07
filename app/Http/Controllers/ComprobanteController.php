<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Support\Facades\Auth;

class ComprobanteController extends Controller
{
    public function show(Pago $pago)
    {
        $pago->load('credito.cliente');

        $usuario = Auth::user();

        if ($usuario->rol === 'cliente') {

            $cliente = $usuario->cliente;

            if (!$cliente || $pago->credito->cliente_id !== $cliente->id) {
                abort(403, 'No tienes permiso para ver este comprobante.');
            }
        }

        return view('comprobantes.show', compact('pago'));
    }
}