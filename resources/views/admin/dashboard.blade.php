@extends('layouts.app')

@section('title', 'Panel Administrador')

@section('content')

    <div class="tarjeta">

        <h1 style="margin-bottom: 5px;">
            Panel de Administración
        </h1>

        <p style="color: #666; margin-top: 0;">
            Bienvenido, {{ auth()->user()->name }}.
            Desde aquí puedes gestionar la información del sistema.
        </p>

    </div>

    <h2 style="margin-top: 30px;">
        Accesos rápidos
    </h2>

    <div style="
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    ">

        <a
            href="{{ route('clientes.index') }}"
            class="boton">
            Gestionar clientes
        </a>

        <a
            href="{{ route('creditos.index') }}"
            class="boton">
            Consultar créditos
        </a>

        <a
            href="{{ route('pagos.index') }}"
            class="boton">
            Consultar pagos
        </a>

    </div>

    <div class="tarjeta" style="margin-top: 30px;">

        <h2>Funciones del administrador</h2>

        <p>
            Como administrador puedes gestionar clientes, consultar créditos,
            supervisar saldos y revisar el historial general de pagos.
        </p>

    </div>

@endsection