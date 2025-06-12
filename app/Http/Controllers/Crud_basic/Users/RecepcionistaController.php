<?php

namespace App\Http\Controllers\Crud_basic\Users;

use App\Http\Controllers\Controller;
use App\RecepcionistaLogic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecepcionistaController extends Controller
{
    protected $recepcionistaLogic;

    public function __construct(RecepcionistaLogic $recepcionistaLogic)
    {
        $this->recepcionistaLogic = $recepcionistaLogic;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|unique:recepcionista|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|unique:recepcionista|max:255',
                'password' => 'required|string|min:5',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255',
                'salario' => 'required|numeric'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        return $this->recepcionistaLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo,
            $request->salario
        );
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
        return $this->recepcionistaLogic->login($request->email, $request->password);
    }

    public function logout(Request $request)
    {
        return $this->recepcionistaLogic->logout($request->user('recepcionista_api'));
    }

    public function user(Request $request)
    {
        return $this->recepcionistaLogic->getAutenticado($request->user('recepcionista_api'));
    }


    public function userAuth(Request $request)
    {
        return $this->recepcionistaLogic->getAutenticado($request->user('recepcionista_api'));
    }

    public function getAll()
    {
        return $this->recepcionistaLogic->getAll();
    }

    public function getByCedula(Request $request)
    {
        return $this->recepcionistaLogic->getByCedula($request->cedula);
    }

    public function getByEmail(Request $request)
    {
        return $this->recepcionistaLogic->getByEmail($request->email);
    }

    public function getByNombre(Request $request)
    {
        return $this->recepcionistaLogic->getByNombre($request->nombre);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
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
            ], 422);
        }

        $array = [
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'salario' => $request->salario
        ];

        
        return $this->recepcionistaLogic->update($request->cedula, $array);
    }

    public function delete(Request $request)
    {
        return $this->recepcionistaLogic->delete($request->cedula);
    }

    // ...existing code...
}
