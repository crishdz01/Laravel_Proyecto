@extends('layouts.app')

@section('title', 'Panel Empleado')

@section('content')

    <div class="tarjeta">

        <h1 style="margin-bottom: 5px;">
            Panel de Empleado
        </h1>

        <p style="color: #666; margin-top: 0;">
            Bienvenido, {{ auth()->user()->name }}.
            Desde aquí puedes realizar las operaciones principales del sistema.
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
            href="{{ route('clientes.create') }}"
            class="boton">
            Registrar cliente
        </a>

        <a
            href="{{ route('creditos.create') }}"
            class="boton">
            Registrar crédito
        </a>

        <a
            href="{{ route('pagos.create') }}"
            class="boton">
            Registrar pago
        </a>

    </div>

    <div class="tarjeta" style="margin-top: 30px;">

        <h2>Funciones del empleado</h2>

        <p>
            Como empleado puedes registrar y consultar clientes,
            registrar créditos, procesar pagos y consultar los
            historiales correspondientes.
        </p>

    </div>  

@endsection