<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema de Créditos')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #212529;
        }

        .barra {
            background-color: #212529;
            color: white;
            padding: 16px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .marca {
            font-size: 22px;
            font-weight: bold;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .menu a {
            color: white;
            text-decoration: none;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .usuario {
            color: #ddd;
        }

        .logout {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: white;
            color: #212529;
        }

        .contenedor {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .tarjeta {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .mensaje-exito {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .boton {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 16px;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }

        .boton:hover {
            opacity: 0.9;
        }

        .boton-secundario {
            background-color: #6c757d;
        }

        .boton-peligro {
            background-color: #dc3545;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        .activo {
            color: #198754;
            font-weight: bold;
        }

        .pagado {
            color: #0d6efd;
            font-weight: bold;
        }

        .vencido {
            color: #dc3545;
            font-weight: bold;
        }

        .inactivo {
            color: #dc3545;
            font-weight: bold;
        }

        @media (max-width: 700px) {
            .barra {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @yield('styles')
    </style>
</head>

<body>

@if(auth()->check())

    <div class="barra">

        <div class="marca">
            Sistema de Créditos
        </div>

        <div class="menu">

            @if(auth()->user()->rol === 'administrador')

                <a href="{{ route('admin.dashboard') }}">
                    Inicio
                </a>

                <a href="{{ route('clientes.index') }}">
                    Clientes
                </a>

                <a href="{{ route('creditos.index') }}">
                    Créditos
                </a>

                <a href="{{ route('pagos.index') }}">
                    Pagos
                </a>

                <a href="{{ route('usuarios.index') }}">
                    Usuarios
                </a>

            @elseif(auth()->user()->rol === 'empleado')

                <a href="{{ route('empleado.dashboard') }}">
                    Inicio
                </a>

                <a href="{{ route('clientes.index') }}">
                    Clientes
                </a>

                <a href="{{ route('creditos.index') }}">
                    Créditos
                </a>

                <a href="{{ route('pagos.create') }}">
                    Registrar pago
                </a>

                <a href="{{ route('pagos.index') }}">
                    Pagos
                </a>

            @elseif(auth()->user()->rol === 'cliente')

                <a href="{{ route('cliente.dashboard') }}">
                    Mi cuenta
                </a>

            @endif

            <span class="usuario">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

@endif


<div class="contenedor">

    @if(session('success'))

        <div class="mensaje-exito">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="mensaje-error">

            <strong>Corrige los siguientes errores:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    @yield('content')

</div>

</body>
</html>