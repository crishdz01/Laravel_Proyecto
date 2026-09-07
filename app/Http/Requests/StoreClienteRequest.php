<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'documento_identidad' => [
                'required',
                'string',
                'max:25',
                'unique:clientes,documento_identidad'
            ],
            'telefono' => ['nullable', 'regex:/^[0-9]{8}$/'],
            'correo' => [
                'nullable',
                'email',
                'max:150',
                'unique:clientes,correo'
            ],
            'direccion' => ['nullable', 'string'],
            'nombres' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'apellidos' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'documento_identidad' => ['required', 'string', 'max:25', 'unique:clientes,documento_identidad'],
            'telefono' => ['nullable', 'regex:/^[0-9]{8}$/'],
            
            'direccion' => ['nullable', 'string', 'max:255'],

        ];
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',

            'documento_identidad.required' =>
                'El documento de identidad es obligatorio.',

            'documento_identidad.unique' =>
                'Este documento de identidad ya está registrado.',

            'correo.email' =>
                'El correo electrónico no tiene un formato válido.',

            'correo.unique' =>
                'Este correo electrónico ya está registrado.',
            'telefono.regex' => 'El teléfono debe contener exactamente 8 números.',
            'nombres.regex' => 'Los nombres solo pueden contener letras y espacios.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'telefono.regex' => 'El teléfono debe contener exactamente 8 números.',

        ];
    }
}