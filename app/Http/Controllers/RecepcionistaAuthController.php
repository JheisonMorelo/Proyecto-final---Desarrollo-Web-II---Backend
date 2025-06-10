<?php

namespace App\Http\Controllers;

use App\Models\Recepcionista; // Asegúrate de importar tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Puedes mantenerlo si usas Hash::make en algún seeder
use Illuminate\Validation\ValidationException;

class RecepcionistaAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::guard('recepcionista_api')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $recepcionista = Auth::guard('recepcionista_api')->user();

        // --- VERIFICACIÓN CRÍTICA ---
        // 1. Verifica si $cliente no es null
        if (!$recepcionista) {
            // Esto no debería pasar si attempt() fue exitoso, pero es un buen punto de depuración.
            return response()->json(['message' => 'Error al obtener el usuario autenticado.'], 500);
        }

        // 2. Verifica si $cliente es una instancia del modelo Cliente
        if (!$recepcionista instanceof Recepcionista) {
            // Esto indicaría un problema en la configuración del guard o del User Provider
            return response()->json(['message' => 'El usuario autenticado no es del tipo esperado.'], 500);
        }
        // --- FIN DE VERIFICACIÓN CRÍTICA ---

        $recepcionista->tokens()->where('name', 'recepcionista-auth-token')->delete();
        $token = $recepcionista->createToken('recepcionista-auth-token', ['role:recepcionista'])->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso.',
            'user' => $recepcionista,
            'token' => $token,
            'role' => 'recepcionista'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('recepcionista_api')->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión de recepcionista cerrada exitosamente.']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user('recepcionista_api'));
    }
}
