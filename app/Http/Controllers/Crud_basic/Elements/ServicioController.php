<?php

namespace App\Http\Controllers\Crud_basic\Elements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\servicioLogic;
use Illuminate\Validation\ValidationException;

class ServicioController extends Controller
{
    protected $servicioLogic;

    public function __construct(servicioLogic $servicioLogic)
    {
        $this->servicioLogic = $servicioLogic;
    }

    public function getAll()
    {
        $servicios = $this->servicioLogic->getAll();
        return response()->$servicios;
    }

    public function getByCodigo(Request $request)
    {
        return $this->servicioLogic->getByCodigo($request->codigo);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|max:20|unique:servicio',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:500',
                'precio' => 'required|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }

        return $this->servicioLogic->create($request->codigo, $request->nombre, $request->descripcion, $request->precio);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|max:20|exists:servicio,codigo',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:500',
                'precio' => 'required|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }

        return $this->servicioLogic->update($request->codigo, $request->nombre, $request->descripcion, $request->precio);
    }

    public function destroy(Request $request)
    {
        return $this->servicioLogic->delete($request->codigo);
    }
}