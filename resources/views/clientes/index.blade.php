@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    ">
        <h1 style="margin: 0;">Clientes</h1>

        <a href="{{ route('clientes.create') }}" class="boton">
            Registrar cliente
        </a>
    </div>

    <div class="tarjeta">

        <form method="GET" action="{{ route('clientes.index') }}">

            <label for="buscar">
                <strong>Buscar cliente</strong>
            </label>

            <input
                type="text"
                id="buscar"
                name="buscar"
                value="{{ $buscar }}"
                placeholder="Nombre, apellido o documento"
            >

            <button type="submit" class="boton">
                Buscar
            </button>

            @if($buscar)
                <a href="{{ route('clientes.index') }}"
                   class="boton boton-secundario">
                    Limpiar
                </a>
            @endif

        </form>

    </div>


    <div class="tarjeta">

        @if($clientes->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($clientes as $cliente)

                        <tr>

                            <td>
                                {{ $cliente->documento_identidad }}
                            </td>

                            <td>
                                {{ $cliente->nombres }}
                                {{ $cliente->apellidos }}
                            </td>

                            <td>
                                {{ $cliente->telefono ?? 'No registrado' }}
                            </td>

                            <td>
                                {{ $cliente->correo ?? 'No registrado' }}
                            </td>

                            <td>
                                <span class="{{ $cliente->estado }}">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                            </td>

                            <td>

                                <a
                                    href="{{ route('clientes.show', $cliente) }}"
                                    class="boton boton-secundario">
                                    Ver
                                </a>
                            
                            
                                <a
                                    href="{{ route('clientes.edit', $cliente) }}"
                                    class="boton">
                                    Editar
                                </a>


                                @if(
                                    auth()->user()->rol === 'administrador'
                                    && $cliente->estado === 'activo'
                                )

                                    <form
                                        action="{{ route('clientes.desactivar', $cliente) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('¿Está seguro de desactivar este cliente?');"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="boton boton-peligro">
                                            Desactivar
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                No se encontraron clientes.
            </p>

        @endif

    </div>

@endsection