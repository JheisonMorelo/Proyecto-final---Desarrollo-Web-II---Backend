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
// Route::post('/asistente/login', [AsistenteVentasAuthController::class, 'login']);
// Route::post('/asistente/register', [AsistenteVentasAuthController::class, 'register']);

// // Rutas protegidas por autenticación de Sanctum para Asistentes de Ventas
// Route::middleware('auth:asistenteVentas_api')->group(function () {
//     // Puedes especificar el guard directamente si lo prefieres: 'auth:asistente_api'
//     Route::post('/asistente/logout', [AsistenteVentasAuthController::class, 'logout']);
//     Route::get('/asistente/autenticado', [AsistenteVentasAuthController::class, 'getAutenticado']);
// });

// // Rutas para eliminar, actualizar y obtener información del asistente de ventas (el asistente de ventas y una cuenta de administrador pueden hacer esto)
// Route::get('/asistente/{id}', [AsistenteVentasAuthController::class, 'getByCedula'])
// ->middleware('auth:asistenteVentas_api');

// Route::put('/asistente/{id}', [AsistenteVentasAuthController::class, 'update'])
// ->middleware('auth:asistenteVentas_api');

// Route::delete('/asistente/{id}', [AsistenteVentasAuthController::class, 'delete'])
// ->middleware('auth:asistenteVentas_api');

// Route::get('/asistente', [AsistenteVentasAuthController::class, 'getAll'])
// ->middleware('auth:asistenteVentas_api');




// // Rutas de autenticación para Recepcionistas
// Route::post('/recepcionista/login', [RecepcionistaAuthController::class, 'login']);
// Route::post('/recepcionista/register', [RecepcionistaAuthController::class, 'register']);

// Route::middleware('auth:recepcionista_api')->group(function () {
//     Route::post('/recepcionista/logout', [RecepcionistaAuthController::class, 'logout']);
//     Route::get('/recepcionista/autenticado', [RecepcionistaAuthController::class, 'getAutenticado']);
// });

// // Rutas para eliminar, actualizar y obtener información del recepcionista (el recepcionista y una cuenta de administrador pueden hacer esto)
// Route::get('/recepcionista/{id}', [RecepcionistaAuthController::class, 'getByCedula'])
//     ->middleware('auth:recepcionista_api');

// Route::put('/recepcionista/{id}', [RecepcionistaAuthController::class, 'update'])
//     ->middleware('auth:recepcionista_api');

// Route::delete('/recepcionista/{id}', [RecepcionistaAuthController::class, 'delete'])
//     ->middleware('auth:recepcionista_api');

// Route::get('/recepcionista', [RecepcionistaAuthController::class, 'getAll'])
//     ->middleware('auth:recepcionista_api');






// // Rutas de autenticación para Especialistas
// Route::post('/especialista/login', [EspecialistaAuthController::class, 'login']);
// Route::post('/especialista/register', [EspecialistaAuthController::class, 'register']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/especialista/logout', [EspecialistaAuthController::class, 'logout']);
//     Route::get('/especialista/autenticado', [EspecialistaAuthController::class, 'getAutenticado']);
// });

// // Rutas para eliminar, actualizar y obtener información del especialista (el especialista y una cuenta de administrador pueden hacer esto)
// Route::get('/especialista/{id}', [EspecialistaAuthController::class, 'getByCedula'])
//     ->middleware('auth:especialista_api');

// Route::put('/especialista/{id}', [EspecialistaAuthController::class, 'update'])
//     ->middleware('auth:especialista_api');

// Route::delete('/especialista/{id}', [EspecialistaAuthController::class, 'delete'])
//     ->middleware('auth:especialista_api');

// Route::get('/especialista', [EspecialistaAuthController::class, 'getAll'])
//     ->middleware('auth:especialista_api');



// // Rutas para registrar, actualizar, eliminar y obtener información de citas
// Route::get('/cita/{codigo}', [App\Http\Controllers\CitaController::class, 'getByCodigo'])
//     ->middleware('auth:recepcionista_api')
//     ->middleware('auth:cliente_api');
// Route::put('/cita/{codigo}', [App\Http\Controllers\CitaController::class, 'update'])
//     ->middleware('auth:recepcionista_api')
//     ->middleware('auth:cliente_api');
// Route::delete('/cita/{codigo}', [App\Http\Controllers\CitaController::class, 'delete'])
//     ->middleware('auth:recepcionista_api')
//     ->middleware('auth:cliente_api');
// Route::get('/cita', [App\Http\Controllers\CitaController::class, 'getAll'])
//     ->middleware('auth:recepcionista_api')
//     ->middleware('auth:cliente_api');
// Route::post('/cita', [App\Http\Controllers\CitaController::class, 'create'])
//     ->middleware('auth:recepcionista_api')
//     ->middleware('auth:cliente_api');


// Rutas para registrar, actualizar, eliminar y obtener información de pedidos
