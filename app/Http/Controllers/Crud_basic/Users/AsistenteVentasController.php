<?php

namespace App\Http\Controllers;

use App\asistenteVentasLogic; // Importa la lógica de asistente de ventas
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AsistenteVentasAuthController extends Controller
{
    protected $asistenteVentasLogic;

    public function __construct(AsistenteVentasLogic $asistenteVentasLogic)
    {
        $this->asistenteVentasLogic = $asistenteVentasLogic;
    }

    /**
     * Registra un nuevo asistente de ventas.
     */
    public function register(Request $request)
    {

        // Validación de los datos de entrada
        try {
            $request->validate([
                'cedula' => 'required|string|max:20|unique:asistente_ventas,cedula',
                'nombre' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:asistente_ventas,email',
                'password' => 'required|string|min:8|confirmed',
                'edad' => 'required|integer|min:18|max:100',
                'sexo' => 'required|string|in:M,F',
                'salario' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        return $this->asistenteVentasLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo,
            $request->salario
        );
    }

    /**
     * Inicia sesión para un asistente de ventas.
     */
    public function login(Request $request)
    {
        // Validación de los campos de inicio de sesión
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        return $this->asistenteVentasLogic->login($request->email, $request->password);
    }

    /**
     * Cierra la sesión del asistente de ventas (revoca el token actual).
     */
    public function logout(Request $request)
    {
        return $this->asistenteVentasLogic->logout($request->user('asistente_api'));
    }

    /**
     * Obtiene los datos del asistente de ventas autenticado.
     */
    public function user(Request $request)
    {
        return $this->asistenteVentasLogic->getAutenticado($request->user('asistente_api'));
    }

    // Mostrar todos asistentes de ventas
    public function getAll()
    {
        return $this->asistenteVentasLogic->getAll();
    }

    // Mostrar un asistente de ventas por cédula
    public function getByCedula($id)
    {
        return $this->asistenteVentasLogic->getByCedula($id);
    }

    // Crear un nuevo asistente de ventas
    public function create(Request $request)
    {
        return $this->asistenteVentasLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo,
            $request->salario
        );
    }


    // Actualizar un asistente de ventas existente
    public function update(Request $request)
    {
        try {
            Request::validate([
                'cedula' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255',
                'salario' => 'nullable|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // Código 422 para errores de validación
        }

        $array = [
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'salario' => $request->salario
        ];

        return $this->asistenteVentasLogic->update($request->cedula, $array);
    }

    // Eliminar un asistente de ventas
    public function delete(Request $request)
    {
        return $this->asistenteVentasLogic->delete($request->cedula);
    }
}