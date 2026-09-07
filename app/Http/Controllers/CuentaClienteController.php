<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CuentaClienteController extends Controller
{
    public function create(Cliente $cliente)
    {
        if ($cliente->usuario_id) {
            return redirect()
                ->route('clientes.show', $cliente)
                ->withErrors([
                    'cuenta' => 'Este cliente ya tiene una cuenta de acceso vinculada.'
                ]);
        }

        return view('clientes.cuenta', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        if ($cliente->usuario_id) {
            return redirect()
                ->route('clientes.show', $cliente)
                ->withErrors([
                    'cuenta' => 'Este cliente ya tiene una cuenta de acceso vinculada.'
                ]);
        }

        $datos = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        DB::transaction(function () use ($datos, $cliente) {

            $usuario = User::create([
                'name' => $cliente->nombres . ' ' . $cliente->apellidos,
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
                'rol' => 'cliente',
            ]);

            $cliente->usuario_id = $usuario->id;
            $cliente->save();
        });

        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cuenta de acceso creada y vinculada correctamente.');
    }
}