<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteAuthController;


// Rutas de autenticación para Clientes

// Rutas protegidas por autenticación de Sanctum para Clientes
Route::middleware('auth:sanctum')->group(function () {
    // Asegúrate de que este middleware 'auth:sanctum' esté configurado para usar tu guard 'cliente_api'
    // en config/auth.php para que solo los tokens de cliente sean válidos aquí.
    // También puedes especificar el guard directamente: Route::middleware('auth:cliente_api')->group(function () {
        
    Route::post('/cliente/login', [ClienteAuthController::class, 'login']);
    Route::post('/cliente/register', [ClienteAuthController::class, 'register']);
    Route::post('/cliente/logout', [ClienteAuthController::class, 'logout']);
    Route::get('/cliente/user', [ClienteAuthController::class, 'user']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
