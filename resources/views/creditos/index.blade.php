@extends('layouts.app')

@section('title', 'Créditos')

@section('content')

    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    ">

        <h1 style="margin: 0;">Créditos</h1>

        <a href="{{ route('creditos.create') }}" class="boton">
            Registrar crédito
        </a>

    </div>


    <div class="tarjeta">

        <form method="GET" action="{{ route('creditos.index') }}">

            <label for="estado">
                <strong>Filtrar por estado</strong>
            </label>

            <select id="estado" name="estado">

                <option value="">
                    Todos
                </option>

                <option value="activo"
                    {{ $estado === 'activo' ? 'selected' : '' }}>
                    Activos
                </option>

                <option value="pagado"
                    {{ $estado === 'pagado' ? 'selected' : '' }}>
                    Pagados
                </option>

                <option value="vencido"
                    {{ $estado === 'vencido' ? 'selected' : '' }}>
                    Vencidos
                </option>

            </select>

            <button type="submit" class="boton">
                Filtrar
            </button>

            @if($estado)

                <a href="{{ route('creditos.index') }}"
                   class="boton boton-secundario">
                    Limpiar
                </a>

            @endif

        </form>

    </div>


    <div class="tarjeta">

        @if($creditos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Crédito</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Interés</th>
                        <th>Total</th>
                        <th>Saldo</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($creditos as $credito)

                        <tr>

                            <td>
                                #{{ $credito->id }}
                            </td>

                            <td>
                                {{ $credito->cliente->nombres }}
                                {{ $credito->cliente->apellidos }}
                            </td>

                            <td>
                                {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                            </td>

                            <td>
                                ${{ number_format($credito->monto, 2) }}
                            </td>

                            <td>
                                {{ number_format($credito->tasa_interes, 2) }}%
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
                            <td>
                                <a
                                    href="{{ route('creditos.show', $credito) }}"
                                    class="boton">
                                    Ver
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>No se encontraron créditos.</p>

        @endif

    </div>

@endsection