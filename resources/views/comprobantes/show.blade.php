@extends('layouts.app')

@section('title', 'Comprobante de Pago')

@section('styles')
    @media print {
        .barra {
            display: none !important;
        }

        .contenedor {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .tarjeta {
            box-shadow: none;
        }

        .acciones-comprobante {
            display: none !important;
        }
    }
@endsection

@section('content')

    <div class="tarjeta">

        <h1 style="text-align: center;">
            Comprobante de Pago
        </h1>

        <p style="text-align: center;">
            Sistema de Gestión de Créditos
        </p>

        <hr>

        <h2>Datos del cliente</h2>

        <p>
            <strong>Nombre:</strong>
            {{ $pago->credito->cliente->nombres }}
            {{ $pago->credito->cliente->apellidos }}
        </p>

        <p>
            <strong>Documento:</strong>
            {{ $pago->credito->cliente->documento_identidad }}
        </p>

        <hr>

        <h2>Datos del crédito</h2>

        <p>
            <strong>Crédito:</strong>
            #{{ $pago->credito->id }}
        </p>

        <p>
            <strong>Monto original:</strong>
            ${{ number_format($pago->credito->monto, 2) }}
        </p>

        <p>
            <strong>Total del crédito:</strong>
            ${{ number_format($pago->credito->total_credito, 2) }}
        </p>

        <p>
            <strong>Saldo actual:</strong>
            ${{ number_format($pago->credito->saldo, 2) }}
        </p>

        <p>
            <strong>Estado:</strong>

            <span class="{{ $pago->credito->estado }}">
                {{ ucfirst($pago->credito->estado) }}
            </span>
        </p>

        <hr>

        <h2>Datos del pago</h2>

        <p>
            <strong>Número de pago:</strong>
            #{{ $pago->id }}
        </p>

        <p>
            <strong>Fecha:</strong>
            {{ $pago->fecha_pago->format('d/m/Y') }}
        </p>

        <p>
            <strong>Monto pagado:</strong>
            ${{ number_format($pago->monto, 2) }}
        </p>

        <p>
            <strong>Referencia:</strong>
            {{ $pago->referencia ?? 'Sin referencia' }}
        </p>

        <p>
            <strong>Observaciones:</strong>
            {{ $pago->observaciones ?? 'Sin observaciones' }}
        </p>

        <div
            class="acciones-comprobante"
            style="margin-top: 30px;"
        >

            <button
                type="button"
                class="boton"
                onclick="window.print()">
                Imprimir comprobante
            </button>

            @if(auth()->user()->rol === 'cliente')

                <a
                    href="{{ route('cliente.dashboard') }}"
                    class="boton boton-secundario">
                    Volver
                </a>

            @else

                <a
                    href="{{ route('pagos.index') }}"
                    class="boton boton-secundario">
                    Volver
                </a>

            @endif

        </div>

    </div>

@endsection