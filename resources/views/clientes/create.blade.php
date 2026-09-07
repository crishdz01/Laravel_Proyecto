@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')

    <h1>Registrar Cliente</h1>

    <div class="tarjeta">

        <form action="{{ route('clientes.store') }}" method="POST">

            @csrf

            <label for="nombres">
                <strong>Nombres *</strong>
            </label>

            <input
                type="text"
                id="nombres"
                name="nombres"
                value="{{ old('nombres') }}"
                required
            >


            <label for="apellidos">
                <strong>Apellidos *</strong>
            </label>

            <input
                type="text"
                id="apellidos"
                name="apellidos"
                value="{{ old('apellidos') }}"
                required
            >


            <label for="documento_identidad">
                <strong>Documento de identidad *</strong>
            </label>

            <input
                type="text"
                id="documento_identidad"
                name="documento_identidad"
                value="{{ old('documento_identidad') }}"
                required
            >


            <label for="telefono">
                <strong>Teléfono</strong>
            </label>

            <input
                type="text"
                id="telefono"
                name="telefono"
                value="{{ old('telefono') }}"
            >


            <label for="correo">
                <strong>Correo electrónico</strong>
            </label>

            <input
                type="email"
                id="correo"
                name="correo"
                value="{{ old('correo') }}"
            >


            <label for="direccion">
                <strong>Dirección</strong>
            </label>

            <textarea
                id="direccion"
                name="direccion"
                rows="4"
            >{{ old('direccion') }}</textarea>


            <button type="submit" class="boton">
                Registrar cliente
            </button>

            <a
                href="{{ route('clientes.index') }}"
                class="boton boton-secundario">
                Cancelar
            </a>

        </form>

    </div>

@endsection