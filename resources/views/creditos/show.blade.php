@extends('layouts.app')

@section('title', 'Detalle del Crédito')

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
            Detalle del Crédito #{{ $credito->id }}
        </h1>

        <a
            href="{{ route('creditos.index') }}"
            class="boton boton-secundario">
            Volver
        </a>
    </div>


    {{-- INFORMACIÓN DEL CRÉDITO --}}

    <div class="tarjeta">

        <h2>Información del Crédito</h2>

        <p>
            <strong>Cliente:</strong>
            {{ $credito->cliente->nombres }}
            {{ $credito->cliente->apellidos }}
        </p>

        <p>
            <strong>Documento:</strong>
            {{ $credito->cliente->documento_identidad }}
        </p>

        <p>
            <strong>Fecha de otorgamiento:</strong>
            {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
        </p>

        <p>
            <strong>Monto otorgado:</strong>
            ${{ number_format($credito->monto, 2) }}
        </p>

        <p>
            <strong>Tasa de interés:</strong>
            {{ number_format($credito->tasa_interes, 2) }}%
        </p>

        <p>
            <strong>Plazo:</strong>
            {{ $credito->plazo }} meses
        </p>

        <p>
            <strong>Total del crédito:</strong>
            ${{ number_format($credito->total_credito, 2) }}
        </p>

        @php
            $totalPagado = $credito->pagos->sum('monto');
        @endphp

        <p>
            <strong>Total pagado:</strong>
            ${{ number_format($totalPagado, 2) }}
        </p>

        <p>
            <strong>Saldo pendiente:</strong>
            ${{ number_format($credito->saldo, 2) }}
        </p>

        <p>
            <strong>Fecha de vencimiento:</strong>
            {{ $credito->fecha_vencimiento->format('d/m/Y') }}
        </p>

        <p>
            <strong>Estado:</strong>

            <span class="{{ $credito->estado }}">
                {{ ucfirst($credito->estado) }}
            </span>
        </p>

    </div>


    {{-- HISTORIAL DE PAGOS --}}

    <h2 style="margin-top: 30px;">
        Historial de Pagos
    </h2>

    <div class="tarjeta">

        @if($credito->pagos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Pago</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                        <th>Observaciones</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($credito->pagos as $pago)

                        <tr>

                            <td>
                                #{{ $pago->id }}
                            </td>

                            <td>
                                {{ $pago->fecha_pago->format('d/m/Y') }}
                            </td>

                            <td>
                                ${{ number_format($pago->monto, 2) }}
                            </td>

                            <td>
                                {{ $pago->referencia ?? 'Sin referencia' }}
                            </td>

                            <td>
                                {{ $pago->observaciones ?? 'Sin observaciones' }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('comprobantes.show', $pago) }}"
                                    class="boton">
                                    Ver
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                Este crédito todavía no tiene pagos registrados.
            </p>

        @endif

    </div>

@endsection