<?php

namespace App\Http\Controllers;

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
}