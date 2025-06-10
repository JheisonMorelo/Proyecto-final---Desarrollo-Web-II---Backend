<?php

namespace App\Http\Controllers;

use App\Models\AsistenteVentas; // Asegúrate de importar tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Puedes mantenerlo si usas Hash::make en algún seeder
use Illuminate\Validation\ValidationException;

class AsistenteVentasAuthController extends Controller
{
        /**
     * Inicia sesión para un asistente de ventas.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::guard('asistente_api')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $asistente = Auth::guard('asistente_api')->user();

        // --- VERIFICACIÓN CRÍTICA ---
        // 1. Verifica si $asistente no es null
        if (!$asistente) {
            // Esto no debería pasar si attempt() fue exitoso, pero es un buen punto de depuración.
            return response()->json(['message' => 'Error al obtener el usuario autenticado.'], 500);
        }

        // 2. Verifica si $cliente es una instancia del modelo Cliente
        if (!$asistente instanceof AsistenteVentas) {
            // Esto indicaría un problema en la configuración del guard o del User Provider
            return response()->json(['message' => 'El usuario autenticado no es del tipo esperado.'], 500);
        }
        // --- FIN DE VERIFICACIÓN CRÍTICA ---

        $asistente->tokens()->where('name', 'asistente-auth-token')->delete();
        $token = $asistente->createToken('asistente-auth-token', ['role:asistente'])->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso.',
            'user' => $asistente,
            'token' => $token,
            'role' => 'asistente'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('asistente_api')->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión de asistente cerrada exitosamente.']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user('asistente_api'));
    }
}


