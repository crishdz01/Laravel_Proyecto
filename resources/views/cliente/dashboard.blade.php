@extends('layouts.app')

@section('title', 'Panel del Cliente')

@section('content')

    <h1>Panel del Cliente</h1>

    {{-- INFORMACIÓN DEL CLIENTE --}}
    <div class="tarjeta">

        <h2>Mi información</h2>

        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        ">

            <p>
                <strong>Nombre:</strong><br>
                {{ $cliente->nombres }} {{ $cliente->apellidos }}
            </p>

            <p>
                <strong>Documento:</strong><br>
                {{ $cliente->documento_identidad }}
            </p>

            <p>
                <strong>Teléfono:</strong><br>
                {{ $cliente->telefono ?? 'No registrado' }}
            </p>

            <p>
                <strong>Correo:</strong><br>
                {{ $cliente->correo ?? 'No registrado' }}
            </p>

            <p>
                <strong>Dirección:</strong><br>
                {{ $cliente->direccion ?? 'No registrada' }}
            </p>

            <p>
                <strong>Estado:</strong><br>
                <span class="{{ $cliente->estado }}">
                    {{ ucfirst($cliente->estado) }}
                </span>
            </p>

        </div>

    </div>


    {{-- CRÉDITOS --}}
    <div class="tarjeta">

        <h2>Mis créditos</h2>

        @if($cliente->creditos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Crédito</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Total</th>
                        <th>Total pagado</th>
                        <th>Saldo</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($cliente->creditos as $credito)

                        <tr>

                            <td>#{{ $credito->id }}</td>

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
                                ${{ number_format($credito->pagos->sum('monto'), 2) }}
                            </td>

                            <td>
                                ${{ number_format($credito->saldo, 2) }}
                            </td>

                            <td>
                                {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                            </td>

                            <td class="{{ $credito->estado }}">
                                {{ ucfirst($credito->estado) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>No tienes créditos registrados.</p>

        @endif

    </div>


    {{-- HISTORIAL DE PAGOS --}}
    <div class="tarjeta">

        <h2>Mi historial de pagos</h2>

        @php
            $hayPagos = false;
        @endphp

        @foreach($cliente->creditos as $credito)

            @if($credito->pagos->count() > 0)

                @php
                    $hayPagos = true;
                @endphp

                <h3>Crédito #{{ $credito->id }}</h3>

                <table>

                    <thead>
                        <tr>
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
                                        Ver comprobante
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @endif

        @endforeach


        @if(!$hayPagos)

            <p>No tienes pagos registrados.</p>

        @endif

    </div>

@endsection