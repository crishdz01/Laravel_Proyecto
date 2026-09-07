<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class ClienteDetalleController extends Controller
{
    public function show(Cliente $cliente)
    {
        $cliente->load([
            'creditos' => function ($query) {
                $query->orderByDesc('fecha_otorgamiento');
            }
        ]);

        return view('clientes.show', compact('cliente'));
    }
}