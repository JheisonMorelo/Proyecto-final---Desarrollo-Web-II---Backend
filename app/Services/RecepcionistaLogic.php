<?php

namespace App;

use App\Models\Recepcionista;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class RecepcionistaLogic
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Registra un nuevo recepcionista.
     *
     * @param string $cedula
     * @param string $nombre
     * @param string $email
     * @param string $password
     * @param int $edad
     * @param string $sexo
     * @param float $salario
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(string $cedula, string $nombre, string $email, string $password, int $edad, string $sexo, float $salario)
    {

        $recepcionista = Recepcionista::create([
            'cedula' => $cedula,
            'nombre' => $nombre,
            'email' => $email,
            'password' => Hash::make($password),
            'edad' => $edad,
            'sexo' => $sexo,
            'salario' => $salario,
            "created_at" => now(),
            "updated_at" => null,
        ]);

        $token = $recepcionista->createToken('recepcionista-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registro de recepcionista exitoso',
            'user' => $recepcionista,
            'token' => $token,
        ], 201);
    }

    /**
     * Inicia sesión un recepcionista con email y contraseña.
     *
     * @param string $email
     * @param string $password
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(string $email, string $password)
    {
        try {
            Request::validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        $recepcionista = Recepcionista::where('email', $email)->first();

        if (!$recepcionista || !Hash::check($password, $recepcionista->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas.'
            ], 401);
        }

        $recepcionista->tokens()->where('name', 'recepcionista-auth-token')->delete();

        $token = $recepcionista->createToken('recepcionista-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión de recepcionista exitoso',
            'user' => $recepcionista,
            'token' => $token,
        ], 200);
    }

    /**
     * Cierra la sesión del recepcionista.
     *
     * @param Recepcionista $recepcionista
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Recepcionista $recepcionista)
    {
        $recepcionista->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    /**
     * Obtiene los datos del recepcionista autenticado.
     *
     * @param Recepcionista $recepcionista
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAutenticado(Recepcionista $recepcionista)
    {
        return response()->json([
            'message' => 'Datos del recepcionista',
            'data' => $recepcionista
        ], 200);
    }

    /**
     * Elimina un recepcionista por su cédula.
     *
     * @param string $cedula
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $cedula)
    {
        $recepcionista = Recepcionista::where('cedula', $cedula)->first();

        if (!$recepcionista) {
            return response()->json(['message' => 'Recepcionista no encontrado'], 404);
        }

        $recepcionista->delete();

        return response()->json(['message' => 'Recepcionista eliminado correctamente'], 200);
    }

    /**
     * Actualiza los datos de un recepcionista.
     *
     * @param Recepcionista $recepcionista
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $cedula, array $data)
    {

        $recepcionista = Recepcionista::where('cedula', $cedula)->first();
        if (!$recepcionista) {
            return response()->json(['message' => 'Recepcionista no encontrado'], 404);
        }

        $recepcionista->update($data);
        return response()->json([
            'message' => 'Datos del recepcionista actualizados correctamente',
            'data' => $recepcionista
        ], 200);
    }

    /**
     * Obtiene todos los recepcionistas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $recepcionistas = Recepcionista::all();
        return response()->json([
            'message' => 'Lista de recepcionistas',
            'data' => $recepcionistas
        ], 200);
    }

    /**
     * Obtiene un recepcionista por su cédula.
     *
     * @param string $cedula
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCedula(string $cedula)
    {
        $recepcionista = Recepcionista::where('cedula', $cedula)->first();

        if (!$recepcionista) {
            return response()->json(['message' => 'Recepcionista no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Datos del recepcionista',
            'data' => $recepcionista
        ], 200);
    }

    public function getByEmail(string $email)
    {
        $recepcionista = Recepcionista::where('email', $email)->first();
        if (!$recepcionista) {
            return response()->json(['message' => 'Recepcionista no encontrado'], 404);
        }
        return response()->json([
            'message' => 'Datos del recepcionista',
            'data' => $recepcionista
        ], 200);
    }

    public function getByNombre(string $nombre)
    {
        $recepcionistas = Recepcionista::where('nombre', 'like', "%$nombre%")->get();
        if ($recepcionistas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron recepcionistas con ese nombre'], 404);
        }
        return response()->json([
            'message' => 'Lista de recepcionistas',
            'data' => $recepcionistas
        ], 200);
    }
    // ...existing code...
}
