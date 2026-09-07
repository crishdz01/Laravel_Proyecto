@extends('layouts.app')

@section('title', 'Registrar Usuario')

@section('content')

    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    ">

        <h1 style="margin: 0;">
            Registrar Usuario
        </h1>

        <a
            href="{{ route('usuarios.index') }}"
            class="boton boton-secundario">
            Volver
        </a>

    </div>

    <div class="tarjeta">

        <form
            action="{{ route('usuarios.store') }}"
            method="POST">

            @csrf

            <label for="name">
                <strong>Nombre completo *</strong>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >

            <label for="email">
                <strong>Correo electrónico *</strong>
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            <label for="rol">
                <strong>Rol *</strong>
            </label>

            <select
                id="rol"
                name="rol"
                required>

                <option value="">
                    Seleccione un rol
                </option>

                <option
                    value="administrador"
                    {{ old('rol') === 'administrador' ? 'selected' : '' }}>
                    Administrador
                </option>

                <option
                    value="empleado"
                    {{ old('rol') === 'empleado' ? 'selected' : '' }}>
                    Empleado
                </option>

            </select>

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
                Registrar usuario
            </button>

        </form>

    </div>

@endsection