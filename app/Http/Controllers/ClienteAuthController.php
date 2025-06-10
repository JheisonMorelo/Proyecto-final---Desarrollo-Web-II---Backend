<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Asegúrate de importar tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class ClienteAuthController extends Controller
{
    /**
     * Registra un nuevo cliente.
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|unique:cliente|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|unique:cliente|max:255',
                'password' => 'required|string|min:5', // 'confirmed' busca un campo password_confirmation
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // Código 422 para errores de validación
        }

        $cliente = Cliente::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            "created_at" => now(),
            "updated_at" => null,
        ]);

        // Autenticar al usuario recién registrado y crear un token
        // Usamos el guard 'cliente_api' como definimos en config/auth.php
        $token = $cliente->createToken('cliente-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registro de cliente exitoso',
            'user' => $cliente,
            'token' => $token,
        ], 201); // Código 201 para "Creado"
    }

    /**
     * Inicia sesión para un cliente.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        // Intentar autenticar con el ORM
        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
                return response()->json([
                    'message' => 'Credenciales inválidas.'
                ], 401);
        }

        //Crea el token para este usuario
        $cliente->tokens()->where('name', 'cliente-auth-token')->delete(); // Elimina tokens antiguos con el mismo nombre
        
        $token = $cliente->createToken('cliente-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión de cliente exitoso',
            'user' => $cliente,
            // 'token' => $token,
        ], 200); // 200 ok
    }

    /**
     * Cierra la sesión del cliente (revoca el token actual).
     */
    public function logout(Request $request)
    {
        // El usuario autenticado es el que tiene el token actual
        $request->user('cliente_api')->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión de cliente cerrada exitosamente']);
    }

    /**
     * Obtiene los datos del cliente autenticado.
     */
    public function user(Request $request)
    {
        // Retorna el usuario autenticado bajo el guard 'cliente_api'
        return response()->json($request->user('cliente_api'));
    }
}

