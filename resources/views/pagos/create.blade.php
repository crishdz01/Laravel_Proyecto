@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')

    <h1>Registrar Pago</h1>

    <div class="tarjeta">

        <form action="{{ route('pagos.store') }}" method="POST">

            @csrf

            <label for="credito_id">
                <strong>Crédito *</strong>
            </label>

            <select
                id="credito_id"
                name="credito_id"
                required
            >

                <option value="">
                    Seleccione un crédito
                </option>

                @foreach($creditos as $credito)

                    <option
                        value="{{ $credito->id }}"
                        data-saldo="{{ $credito->saldo }}"
                        {{ old('credito_id') == $credito->id ? 'selected' : '' }}
                    >
                        Crédito #{{ $credito->id }}
                        -
                        {{ $credito->cliente->nombres }}
                        {{ $credito->cliente->apellidos }}
                        -
                        Saldo: ${{ number_format($credito->saldo, 2) }}
                    </option>

                @endforeach

            </select>


            <div
                id="saldo-info"
                style="
                    margin-bottom: 15px;
                    padding: 12px;
                    background-color: #e9ecef;
                    border-radius: 5px;
                "
            >
                Saldo pendiente:
                <strong id="saldo-valor">$0.00</strong>
            </div>


            <label for="fecha_pago">
                <strong>Fecha del pago *</strong>
            </label>

            <input
                type="date"
                id="fecha_pago"
                name="fecha_pago"
                value="{{ old('fecha_pago') }}"
                required
            >


            <label for="monto">
                <strong>Monto del pago *</strong>
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


            <label for="referencia">
                <strong>Referencia</strong>
            </label>

            <input
                type="text"
                id="referencia"
                name="referencia"
                value="{{ old('referencia') }}"
                maxlength="100"
            >


            <label for="observaciones">
                <strong>Observaciones</strong>
            </label>

            <textarea
                id="observaciones"
                name="observaciones"
                rows="4"
            >{{ old('observaciones') }}</textarea>


            <button type="submit" class="boton">
                Registrar pago
            </button>

            <a
                href="{{ route('pagos.index') }}"
                class="boton boton-secundario">
                Cancelar
            </a>

        </form>

    </div>


    <script>
        const creditoSelect = document.getElementById('credito_id');
        const montoInput = document.getElementById('monto');
        const saldoValor = document.getElementById('saldo-valor');

        function actualizarSaldo() {

            const opcion = creditoSelect.options[creditoSelect.selectedIndex];

            if (!opcion || !opcion.dataset.saldo) {
                saldoValor.textContent = '$0.00';
                montoInput.removeAttribute('max');
                return;
            }

            const saldo = parseFloat(opcion.dataset.saldo);

            saldoValor.textContent =
                '$' + saldo.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            montoInput.max = saldo;
        }

        creditoSelect.addEventListener('change', actualizarSaldo);

        actualizarSaldo();
    </script>

@endsection