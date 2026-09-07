<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'credito_id' => [
                'required',
                'exists:creditos,id'
            ],

            'fecha_pago' => [
                'required',
                'date'
            ],

            'monto' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'referencia' => [
                'nullable',
                'string',
                'max:100'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'credito_id.required' =>
                'Debe seleccionar un crédito.',

            'credito_id.exists' =>
                'El crédito seleccionado no existe.',

            'fecha_pago.required' =>
                'La fecha del pago es obligatoria.',

            'fecha_pago.date' =>
                'La fecha del pago no es válida.',

            'monto.required' =>
                'El monto del pago es obligatorio.',

            'monto.numeric' =>
                'El monto debe ser un valor numérico.',

            'monto.min' =>
                'El monto del pago debe ser mayor que cero.',

            'referencia.max' =>
                'La referencia no puede tener más de 100 caracteres.',
        ];
    }
}