@extends('layouts.app')

@section('title', 'Crear Cuenta de Cliente')

@section('content')

    <h1>Crear Cuenta de Acceso</h1>

    <div class="tarjeta">

        <h2>
            {{ $cliente->nombres }}
            {{ $cliente->apellidos }}
        </h2>

        <p>
            <strong>Documento:</strong>
            {{ $cliente->documento_identidad }}
        </p>

        <form
            action="{{ route('clientes.cuenta.store', $cliente) }}"
            method="POST"
        >

            @csrf

            <label for="email">
                <strong>Correo de acceso *</strong>
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $cliente->correo) }}"
                required
            >

            <label for="password">
                <strong>Contraseña *</strong>
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <label for="password_confirmation">
                <strong>Confirmar contraseña *</strong>
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >

            <button
                type="submit"
                class="boton">
                Crear cuenta
            </button>

            <a
                href="{{ route('clientes.show', $cliente) }}"
                class="boton boton-secundario">
                Cancelar
            </a>

        </form>

    </div>

@endsection