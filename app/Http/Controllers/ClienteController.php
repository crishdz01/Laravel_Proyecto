<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $clientes = Cliente::when($buscar, function ($query, $buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                ->orWhere('apellidos', 'like', "%{$buscar}%")
                ->orWhere('documento_identidad', 'like', "%{$buscar}%");
            });
        })
        ->orderBy('nombres')
        ->get();

        return view('clientes.index', compact('clientes', 'buscar'));
    }
    public function create()
    {
        return view('clientes.create');
    }
    public function store(StoreClienteRequest $request)
    {
        $datos = $request->validated();

        $datos['estado'] = 'activo';

        Cliente::create($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $datos = $request->validated();

        $cliente->update($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }
    public function desactivar(Cliente $cliente)
    {
        $cliente->update([
            'estado' => 'inactivo'
        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente desactivado correctamente.');
    }

    public function activar(Cliente $cliente)
    {
        $cliente->update([
            'estado' => 'activo'
        ]);

        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente activado correctamente.');
    }
}