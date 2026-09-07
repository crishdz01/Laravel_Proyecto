<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Credito;

class ClienteDashboardController extends Controller
{
    public function index()
    {
        Credito::actualizarVencidos();
    
        $usuario = Auth::user();

        $cliente = $usuario->cliente;

        if (!$cliente) {
            abort(403, 'Este usuario no tiene un cliente asociado.');
        }

        $cliente->load([
            'creditos' => function ($query) {
                $query->orderByDesc('fecha_otorgamiento');
            },
            'creditos.pagos' => function ($query) {
                $query->orderByDesc('fecha_pago');
            }
        ]);

        return view('cliente.dashboard', compact('cliente'));
    }
}