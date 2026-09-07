@extends('layouts.app')

@section('title', 'Registrar Crédito')

@section('content')

    <h1>Registrar Crédito</h1>

    <div class="tarjeta">

        <form action="{{ route('creditos.store') }}" method="POST">

            @csrf

            <label for="cliente_id">
                <strong>Cliente *</strong>
            </label>

            <select
                id="cliente_id"
                name="cliente_id"
                required
            >

                <option value="">
                    Seleccione un cliente
                </option>

                @foreach($clientes as $cliente)

                    <option
                        value="{{ $cliente->id }}"
                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}
                    >
                        {{ $cliente->nombres }}
                        {{ $cliente->apellidos }}
                        - {{ $cliente->documento_identidad }}
                    </option>

                @endforeach

            </select>


            <label for="fecha_otorgamiento">
                <strong>Fecha de otorgamiento *</strong>
            </label>

            <input
                type="date"
                id="fecha_otorgamiento"
                name="fecha_otorgamiento"
                value="{{ old('fecha_otorgamiento') }}"
                required
            >


            <label for="monto">
                <strong>Monto *</strong>
            </label>

            <input
                type="number"
                id="monto"
                name="monto"
                value="{{ old('monto') }}"
                min="0.01"
                step="0.01"
                required
            >


            <label for="tasa_interes">
                <strong>Tasa de interés (%) *</strong>
            </label>

            <input
                type="number"
                id="tasa_interes"
                name="tasa_interes"
                value="{{ old('tasa_interes') }}"
                min="0"
                step="0.01"
                required
            >


            <label for="plazo">
                <strong>Plazo en meses *</strong>
            </label>

            <input
                type="number"
                id="plazo"
                name="plazo"
                value="{{ old('plazo') }}"
                min="1"
                step="1"
                required
            >


            <button type="submit" class="boton">
                Registrar crédito
            </button>

            <a
                href="{{ route('creditos.index') }}"
                class="boton boton-secundario">
                Cancelar
            </a>

        </form>

    </div>

@endsection