<?php

namespace App\Http\Controllers;

use App\Models\Especialista; // Asegúrate de importar tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Puedes mantenerlo si usas Hash::make en algún seeder
use Illuminate\Validation\ValidationException;

class EspecialistaAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::guard('especialista_api')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $especialista = Auth::guard('especialista_api')->user();

        // --- VERIFICACIÓN CRÍTICA ---
        // 1. Verifica si $cliente no es null
        if (!$especialista) {
            // Esto no debería pasar si attempt() fue exitoso, pero es un buen punto de depuración.
            return response()->json(['message' => 'Error al obtener el usuario autenticado.'], 500);
        }

        // 2. Verifica si $cliente es una instancia del modelo Cliente
        if (!$especialista instanceof Especialista) {
            // Esto indicaría un problema en la configuración del guard o del User Provider
            return response()->json(['message' => 'El usuario autenticado no es del tipo esperado.'], 500);
        }
        // --- FIN DE VERIFICACIÓN CRÍTICA ---

        $especialista->tokens()->where('name', 'especialista-auth-token')->delete();
        $token = $especialista->createToken('especialista-auth-token', ['role:especialista'])->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso.',
            'user' => $especialista,
            'token' => $token,
            'role' => 'especialista'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('especialista_api')->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión de especialista cerrada exitosamente.']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user('especialista_api'));
    }
}
