@extends('layouts.app')

@section('title', 'Historial de Pagos')

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
            Historial de Pagos
        </h1>

        @if(auth()->user()->rol === 'empleado')

            <a href="{{ route('pagos.create') }}" class="boton">
                Registrar pago
            </a>

        @endif

    </div>


    <div class="tarjeta">

        @if($pagos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Pago</th>
                        <th>Crédito</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                        <th>Observaciones</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pagos as $pago)

                        <tr>

                            <td>
                                #{{ $pago->id }}
                            </td>

                            <td>
                                #{{ $pago->credito->id }}
                            </td>

                            <td>
                                {{ $pago->credito->cliente->nombres }}
                                {{ $pago->credito->cliente->apellidos }}
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
                                    Ver comprobante
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>No hay pagos registrados.</p>

        @endif

    </div>

@endsection