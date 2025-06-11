<?php

namespace App\Http\Controllers\Crud_basic\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\ClienteLogic;

class ClienteController extends Controller
{
    protected $clienteLogic;

    public function __construct(ClienteLogic $clienteLogic)
    {
        $this->clienteLogic = $clienteLogic;
    }

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
                'password' => 'required|string|min:5',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // Código 422 para errores de validación
        }
        
        return $this->clienteLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo
        );
    }
    
    /**
     * Inicia sesión para un cliente.
     */
    public function login(Request $request)
    {
        try {
            // Validación de los campos de inicio de sesión
            $request->validate(['email' => 'required|string|email', 'password' => 'required|string']);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // Código 422 para errores de validación
        }
        return $this->clienteLogic->login($request->email, $request->password);
    }

    /**
     * Cierra la sesión del cliente (revoca el token actual).
     */
    public function logout(Request $request)
    {
        return $this->clienteLogic->logout($request->user('cliente_api'));
    }

    /**
     * Obtiene los datos del cliente autenticado.
     */
    public function userAuth(Request $request)
    {
        // Retorna el usuario autenticado bajo el guard 'cliente_api'
        return $this->clienteLogic->getAutenticado($request->user('cliente_api'));
    }

    // Mostrar todos los clientes
    public function getAll()
    {
        return $this->clienteLogic->getAll();
    }

    // Mostrar un cliente específico
    public function getByCedula(Request $request)
    {
        return $this->clienteLogic->getByCedula($request->cedula);
    }

    public function getByEmail(Request $request)
    {
        return $this->clienteLogic->getByEmail($request->email);
    }

    public function getByNombre(Request $request)
    {
        return $this->clienteLogic->getByNombre($request->nombre);
    }

    // Actualizar un cliente existente
    public function update(Request $request)
    {
        try {
            Request::validate([
                'cedula' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // Código 422 para errores de validación
        }
        return $this->clienteLogic->update( 
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->edad,
            $request->sexo
        );
    }

    // Eliminar un cliente
    public function delete(Request $request)
    {
        return $this->clienteLogic->delete($request->cedula);
    }
}
