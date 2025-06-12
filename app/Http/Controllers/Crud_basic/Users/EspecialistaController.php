<?php

namespace App\Http\Controllers\Crud_basic\Users;

use App\Http\Controllers\Controller;
use App\EspecialistaLogic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspecialistaController extends Controller
{
    protected $especialistaLogic;

    public function __construct(EspecialistaLogic $especialistaLogic)
    {
        $this->especialistaLogic = $especialistaLogic;
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|unique:especialista|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|unique:especialista|max:255',
                'password' => 'required|string|min:5',
                'edad' => 'required|integer|min:18|max:100',
                'sexo' => 'required|string|in:M,F',
                'rol' => 'required|string|max:50',
                'salario' => 'required|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        return $this->especialistaLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo,
            $request->rol,
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
        return $this->especialistaLogic->login($request->email, $request->password);
    }

    public function logout(Request $request)
    {
        return $this->especialistaLogic->logout($request->user('especialista_api'));
    }

    public function user(Request $request)
    {
        return $this->especialistaLogic->getAuth($request->user('especialista_api'));
    }

    public function getAll()
    {
        return $this->especialistaLogic->getAll();
    }

    public function getByCedula(Request $request)
    {
        return $this->especialistaLogic->getByCedula($request->cedula);
    }

    public function getByEmail(Request $request)
    {
        return $this->especialistaLogic->getByEmail($request->email);
    }

    public function getByNombre(Request $request)
    {
        return $this->especialistaLogic->getByNombre($request->nombre);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'edad' => 'required|integer|min:18|max:100',
                'sexo' => 'required|string|in:M,F',
                'rol' => 'required|string|max:50',
                'salario' => 'required|numeric|min:0'
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
            'rol' => $request->rol,
            'salario' => $request->salario
        ];

        return $this->especialistaLogic->update($request->cedula, $array);
    }

    public function delete(Request $request)
    {
        return $this->especialistaLogic->delete($request->cedula);
    }
    // ...existing code...
}
