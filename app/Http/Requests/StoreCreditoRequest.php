<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => [
                'required',
                'exists:clientes,id'
            ],

            'fecha_otorgamiento' => [
                'required',
                'date'
            ],

            'monto' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'tasa_interes' => [
                'required',
                'numeric',
                'min:0'
            ],

            'plazo' => [
                'required',
                'integer',
                'min:1'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' =>
                'Debe seleccionar un cliente.',

            'cliente_id.exists' =>
                'El cliente seleccionado no existe.',

            'fecha_otorgamiento.required' =>
                'La fecha de otorgamiento es obligatoria.',

            'fecha_otorgamiento.date' =>
                'La fecha de otorgamiento no es válida.',

            'monto.required' =>
                'El monto del crédito es obligatorio.',

            'monto.numeric' =>
                'El monto debe ser un valor numérico.',

            'monto.min' =>
                'El monto debe ser mayor que cero.',

            'tasa_interes.required' =>
                'La tasa de interés es obligatoria.',

            'tasa_interes.numeric' =>
                'La tasa de interés debe ser un valor numérico.',

            'tasa_interes.min' =>
                'La tasa de interés no puede ser negativa.',

            'plazo.required' =>
                'El plazo es obligatorio.',

            'plazo.integer' =>
                'El plazo debe ser un número entero.',

            'plazo.min' =>
                'El plazo debe ser de al menos un mes.',
        ];
    }
}