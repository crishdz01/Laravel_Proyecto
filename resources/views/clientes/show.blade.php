@extends('layouts.app')

@section('title', 'Detalle del Cliente')

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
            Detalle del Cliente
        </h1>

        <a
            href="{{ route('clientes.index') }}"
            class="boton boton-secundario">
            Volver
        </a>
    </div>


    {{-- INFORMACIÓN DEL CLIENTE --}}

    <div class="tarjeta">

        <h2>
            {{ $cliente->nombres }}
            {{ $cliente->apellidos }}
        </h2>

        <p>
            <strong>Documento:</strong>
            {{ $cliente->documento_identidad }}
        </p>

        <p>
            <strong>Teléfono:</strong>
            {{ $cliente->telefono ?? 'No registrado' }}
        </p>

        <p>
            <strong>Correo:</strong>
            {{ $cliente->correo ?? 'No registrado' }}
        </p>

        <p>
            <strong>Dirección:</strong>
            {{ $cliente->direccion ?? 'No registrada' }}
        </p>

        <p>
            <strong>Estado:</strong>

            <span class="{{ $cliente->estado }}">
                {{ ucfirst($cliente->estado) }}
            </span>
        </p>

        <a
            href="{{ route('clientes.edit', $cliente) }}"
            class="boton">
            Editar cliente
        </a>

        @if(auth()->user()->rol === 'administrador')

        @if($cliente->estado === 'activo')

            <form
                action="{{ route('clientes.desactivar', $cliente) }}"
                method="POST"
                style="display: inline-block;"
                onsubmit="return confirm('¿Está seguro de desactivar a este cliente? Esta acción impedirá registrar nuevos créditos, pero conservará su historial.');"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="boton boton-peligro">
                    Desactivar cliente
                </button>
            </form>

        @else

            <form
                action="{{ route('clientes.activar', $cliente) }}"
                method="POST"
                style="display: inline-block;"
                onsubmit="return confirm('¿Desea activar nuevamente a este cliente?');"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="boton">
                    Activar cliente
                </button>
            </form>

        @endif

    @endif

        @if(auth()->user()->rol === 'administrador')

        @if(!$cliente->usuario_id)

            <a
                href="{{ route('clientes.cuenta.create', $cliente) }}"
                class="boton">
                Crear cuenta de acceso
            </a>

        @else

            <p style="margin-top: 15px;">
                <strong>Cuenta de acceso:</strong>
                Vinculada
            </p>

            @if($cliente->usuario)

                <p>
                    <strong>Correo de acceso:</strong>
                    {{ $cliente->usuario->email }}
                </p>

            @endif

        @endif

    @endif

    </div>


    {{-- HISTORIAL DE CRÉDITOS --}}

    <h2 style="margin-top: 30px;">
        Historial de Créditos
    </h2>

    <div class="tarjeta">

        @if($cliente->creditos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Crédito</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Total</th>
                        <th>Saldo</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($cliente->creditos as $credito)

                        <tr>

                            <td>
                                #{{ $credito->id }}
                            </td>

                            <td>
                                {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                            </td>

                            <td>
                                ${{ number_format($credito->monto, 2) }}
                            </td>

                            <td>
                                ${{ number_format($credito->total_credito, 2) }}
                            </td>

                            <td>
                                ${{ number_format($credito->saldo, 2) }}
                            </td>

                            <td>
                                {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                            </td>

                            <td>
                                <span class="{{ $credito->estado }}">
                                    {{ ucfirst($credito->estado) }}
                                </span>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                Este cliente no posee historial de créditos.
            </p>

        @endif

    </div>

@endsection