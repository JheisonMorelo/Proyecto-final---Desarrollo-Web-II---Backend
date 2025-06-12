<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crud_basic\Users\ClienteController;
use App\Http\Controllers\Crud_basic\Users\AsistenteVentasController;
use App\Http\Controllers\Crud_basic\Users\RecepcionistaController;
use App\Http\Controllers\Crud_basic\Users\EspecialistaController;

// Rutas de autenticación para Clientes
Route::post('/cliente/register', [ClienteController::class, 'register']);
Route::post('/cliente/login', [ClienteController::class, 'login']);

// Rutas protegidas por autenticación de Sanctum para Clientes
Route::middleware('auth:cliente_api')->group(function () {

    Route::get('/cliente/logout', [ClienteController::class, 'logout']);
    Route::get('/cliente/autenticado', [ClienteController::class, 'userAuth']);
});

// Rutas para eliminar, actualizar y obtener información del cliente (el recepcionista y el cliente pueden hacer esto)

Route::get('/cliente/search-cedula', [ClienteController::class, 'getByCedula'])
    ->middleware('auth.client_recep');

Route::get('/cliente/search-email', [ClienteController::class, 'getByEmail'])
    ->middleware('auth.client_recep');

Route::get('/cliente/search-nombre', [ClienteController::class, 'getByNombre'])
    ->middleware('auth.client_recep');

Route::put('/cliente/update', [ClienteController::class, 'update'])
    ->middleware('auth.client_recep');

Route::delete('/cliente/delete', [ClienteController::class, 'delete'])
    ->middleware('auth.client_recep');

Route::get('/cliente/all', [ClienteController::class, 'getAll'])
    ->middleware('auth.client_recep');





// Rutas de autenticación para Asistentes de Ventas
Route::post('/asistente/login', [AsistenteVentasController::class, 'login']);
Route::post('/asistente/register', [AsistenteVentasController::class, 'register']);

// Rutas protegidas por autenticación de Sanctum para Asistentes de Ventas
Route::middleware('auth:asistenteVentas_api')->group(function () {
     // Puedes especificar el guard directamente si lo prefieres: 'auth:asistente_api'
     Route::get('/asistente/logout', [AsistenteVentasController::class, 'logout']);
     Route::get('/asistente/autenticado', [AsistenteVentasController::class, 'getAutenticado']);
 });

// Rutas para eliminar, actualizar y obtener información del asistente de ventas (el asistente de ventas y una cuenta de administrador pueden hacer esto)
Route::get('/asistente/search-cedula', [AsistenteVentasController::class, 'getByCedula']);

Route::get('/asistente/search-email', [AsistenteVentasController::class, 'getByEmail']);

Route::get('/asistente/search-nombre', [AsistenteVentasController::class, 'getByNombre']);

Route::put('/asistente/update', [AsistenteVentasController::class, 'update']);

Route::delete('/asistente/delete', [AsistenteVentasController::class, 'delete']);

Route::get('/asistente/all', [AsistenteVentasController::class, 'getAll']);




// Rutas de autenticación para Recepcionistas
Route::post('/recepcionista/register', [RecepcionistaController::class, 'register']);
Route::post('/recepcionista/login', [RecepcionistaController::class, 'login']);

// Rutas protegidas por autenticación de Sanctum para Recepcionistas
Route::middleware('auth:recepcionista_api')->group(function () {
    Route::get('/recepcionista/logout', [RecepcionistaController::class, 'logout']);
    Route::get('/recepcionista/autenticado', [RecepcionistaController::class, 'userAuth']);
});

// Rutas para eliminar, actualizar y obtener información del recepcionista
Route::get('/recepcionista/search-cedula', [RecepcionistaController::class, 'getByCedula'])
    ->middleware('auth:recepcionista_api');
Route::get('/recepcionista/search-email', [RecepcionistaController::class, 'getByEmail'])
    ->middleware('auth:recepcionista_api');
Route::get('/recepcionista/search-nombre', [RecepcionistaController::class, 'getByNombre'])
    ->middleware('auth:recepcionista_api');
Route::put('/recepcionista/update', [RecepcionistaController::class, 'update'])
    ->middleware('auth:recepcionista_api');
Route::delete('/recepcionista/delete', [RecepcionistaController::class, 'delete'])
    ->middleware('auth:recepcionista_api');
Route::get('/recepcionista/all', [RecepcionistaController::class, 'getAll'])
    ->middleware('auth:recepcionista_api');







// Rutas de autenticación para Especialistas
Route::post('/especialista/register', [EspecialistaController::class, 'register']);
Route::post('/especialista/login', [EspecialistaController::class, 'login']);

// Rutas protegidas por autenticación de Sanctum para Especialistas
Route::middleware('auth:especialista_api')->group(function () {
    Route::get('/especialista/logout', [EspecialistaController::class, 'logout']);
    Route::get('/especialista/autenticado', [EspecialistaController::class, 'user']);
});

// Rutas para eliminar, actualizar y obtener información del especialista
Route::get('/especialista/search-cedula', [EspecialistaController::class, 'getByCedula'])
    ->middleware('auth:especialista_api');
Route::get('/especialista/search-email', [EspecialistaController::class, 'getByEmail'])
    ->middleware('auth:especialista_api');
Route::get('/especialista/search-nombre', [EspecialistaController::class, 'getByNombre'])
    ->middleware('auth:especialista_api');
Route::put('/especialista/update', [EspecialistaController::class, 'update'])
    ->middleware('auth:especialista_api');
Route::delete('/especialista/delete', [EspecialistaController::class, 'delete'])
    ->middleware('auth:especialista_api');
Route::get('/especialista/all', [EspecialistaController::class, 'getAll'])
    ->middleware('auth:especialista_api');

// Rutas para Citas
use App\Http\Controllers\Crud_basic\Elements\CitaController;
Route::middleware(['auth:recepcionista_api'])->group(function () {
    Route::get('/cita/all', [CitaController::class, 'getAll']);
    Route::post('/cita/get', [CitaController::class, 'getByCodigo']);
    Route::post('/cita/create', [CitaController::class, 'create']);
    Route::put('/cita/update', [CitaController::class, 'update']);
    Route::delete('/cita/delete', [CitaController::class, 'destroy']);
});

// Rutas para Pedidos
use App\Http\Controllers\Crud_basic\Elements\PedidoController;
Route::middleware(['auth:recepcionista_api'])->group(function () {
    Route::get('/pedido/all', [PedidoController::class, 'getAll']);
    Route::post('/pedido/get', [PedidoController::class, 'getByCodigo']);
    Route::post('/pedido/create', [PedidoController::class, 'create']);
    Route::put('/pedido/update', [PedidoController::class, 'update']);
    Route::delete('/pedido/delete', [PedidoController::class, 'destroy']);
});

// Rutas para Informes
use App\Http\Controllers\Crud_basic\Elements\InformeController;
Route::middleware(['auth:recepcionista_api'])->group(function () {
    Route::get('/informe/all', [InformeController::class, 'getAll']);
    Route::post('/informe/get', [InformeController::class, 'getByCodigo']);
    Route::post('/informe/create', [InformeController::class, 'create']);
    Route::put('/informe/update', [InformeController::class, 'update']);
    Route::delete('/informe/delete', [InformeController::class, 'destroy']);
});

// Rutas para Servicios
use App\Http\Controllers\Crud_basic\Elements\ServicioController;
Route::middleware(['auth:recepcionista_api'])->group(function () {
    Route::get('/servicio/all', [ServicioController::class, 'getAll']);
    Route::post('/servicio/get', [ServicioController::class, 'getByCodigo']);
    Route::post('/servicio/create', [ServicioController::class, 'create']);
    Route::put('/servicio/update', [ServicioController::class, 'update']);
    Route::delete('/servicio/delete', [ServicioController::class, 'destroy']);
});

// Rutas para Productos
use App\Http\Controllers\Crud_basic\Elements\ProductoController;
Route::middleware(['auth:recepcionista_api'])->group(function () {
    Route::get('/producto/all', [ProductoController::class, 'getAll']);
    Route::post('/producto/get', [ProductoController::class, 'getByCodigo']);
    Route::post('/producto/create', [ProductoController::class, 'create']);
    Route::put('/producto/update', [ProductoController::class, 'update']);
    Route::delete('/producto/delete', [ProductoController::class, 'destroy']);
});

// Rutas para registrar, actualizar, eliminar y obtener información de pedidos
