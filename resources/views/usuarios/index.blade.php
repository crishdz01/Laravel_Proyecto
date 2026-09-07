@extends('layouts.app')

@section('title', 'Usuarios')

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
            Usuarios
        </h1>

        <a
            href="{{ route('usuarios.create') }}"
            class="boton">
            Nuevo usuario
        </a>

    </div>

    <div class="tarjeta">

        @if($usuarios->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($usuarios as $usuario)

                        <tr>

                            <td>
                                {{ $usuario->name }}
                            </td>

                            <td>
                                {{ $usuario->email }}
                            </td>

                            <td>
                                {{ ucfirst($usuario->rol) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                No hay administradores o empleados registrados.
            </p>

        @endif

    </div>

@endsection