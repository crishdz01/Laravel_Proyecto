<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\ComprobanteController;
use App\Http\Controllers\ClienteDetalleController;
use App\Http\Controllers\CreditoDetalleController;
use App\Http\Controllers\CuentaClienteController;
use App\Http\Controllers\UsuarioController; 

// =========================
// AUTENTICACIÓN
// =========================

Route::get('/login', [LoginController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.procesar');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
Route::get('/clientes', [ClienteController::class, 'index'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.index');
Route::get('/clientes/crear', [ClienteController::class, 'create'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.create');
Route::get('/clientes/{cliente}', [ClienteDetalleController::class, 'show'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.show');
Route::post('/clientes', [ClienteController::class, 'store'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.store');   
Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.edit');

Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('clientes.update');
Route::patch('/clientes/{cliente}/desactivar', [ClienteController::class, 'desactivar'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('clientes.desactivar');
Route::get('/creditos', [CreditoController::class, 'index'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('creditos.index');

Route::get('/creditos/crear', [CreditoController::class, 'create'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('creditos.create');
Route::get('/creditos/{credito}', [CreditoDetalleController::class, 'show'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('creditos.show');
Route::post('/creditos', [CreditoController::class, 'store'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('creditos.store');
Route::get('/pagos', [PagoController::class, 'index'])
    ->middleware(['auth', 'rol:administrador,empleado'])
    ->name('pagos.index');

Route::get('/pagos/crear', [PagoController::class, 'create'])
    ->middleware(['auth', 'rol:empleado'])
    ->name('pagos.create');
Route::post('/pagos', [PagoController::class, 'store'])
    ->middleware(['auth', 'rol:empleado'])
    ->name('pagos.store');
Route::get('/comprobantes/{pago}', [ComprobanteController::class, 'show'])
    ->middleware(['auth', 'rol:administrador,empleado,cliente'])
    ->name('comprobantes.show');

Route::get('/clientes/{cliente}/cuenta/crear', [CuentaClienteController::class, 'create'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('clientes.cuenta.create');

Route::post('/clientes/{cliente}/cuenta', [CuentaClienteController::class, 'store'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('clientes.cuenta.store');
Route::patch('/clientes/{cliente}/activar', [ClienteController::class, 'activar'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('clientes.activar');

Route::get('/usuarios', [UsuarioController::class, 'index'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('usuarios.index');

Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('usuarios.create');

Route::post('/usuarios', [UsuarioController::class, 'store'])
    ->middleware(['auth', 'rol:administrador'])
    ->name('usuarios.store');

Route::get('/', function () {
    return redirect()->route('login');
});


// =========================
// PANELES PROVISIONALES
// =========================

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'rol:administrador'])
  ->name('admin.dashboard');

Route::get('/empleado', function () {
    return view('empleado.dashboard');
})->middleware(['auth', 'rol:empleado'])
  ->name('empleado.dashboard');

Route::get('/cliente', [ClienteDashboardController::class, 'index'])
    ->middleware(['auth', 'rol:cliente'])
    ->name('cliente.dashboard');