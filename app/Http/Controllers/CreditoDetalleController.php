<?php

namespace App\Http\Controllers;

use App\Models\Credito;

class CreditoDetalleController extends Controller
{
    public function show(Credito $credito)
    {
        $credito->load([
            'cliente',
            'pagos' => function ($query) {
                $query->orderByDesc('fecha_pago');
            }
        ]);

        return view('creditos.show', compact('credito'));
    }
}