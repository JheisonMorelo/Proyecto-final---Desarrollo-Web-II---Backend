<?php

namespace App\Http\Controllers;

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
        // Validación de los datos de entrada
        try {
            $request->validate([
                'cedula' => 'required|string|max:20|unique:especialistas,cedula',
                'nombre' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:especialistas,email',
                'password' => 'required|string|min:8',
                'edad' => 'required|integer|min:18|max:100',
                'sexo' => 'required|string|in:M,F',
                'rol' => 'required|string|max:50',
                'salario' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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

    // Método para obtener todos los especialistas
    public function getAll(Request $request)
    {
        return $this->especialistaLogic->getAll();
    }

    // Método para obtener un especialista por ID
    public function getById(Request $request)
    {
        return $this->especialistaLogic->getByCedula($request->id);
    }

    // Método para actualizar un especialista
    public function update(Request $request)
    {
        // Validación de los datos de entrada
        try {
            $request->validate([
                'cedula' => 'required|string|max:20|unique:especialistas,cedula,' . $request->id,
                'nombre' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:especialistas,email,' . $request->id,
                'edad' => 'required|integer|min:18|max:100',
                'sexo' => 'required|string|in:M,F',
                'rol' => 'required|string|max:50',
                'salario' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $array = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'rol' => $request->rol,
            'salario' => $request->salario
        ];

        return $this->especialistaLogic->update($request->cedula, $array);
    }
}