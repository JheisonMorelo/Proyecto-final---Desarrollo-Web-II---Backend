<?php

namespace App\Http\Controllers\Crud_basic\Elements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\productoLogic;
use Illuminate\Validation\ValidationException;

class ProductoController extends Controller
{
    protected $productoLogic;

    public function __construct(productoLogic $productoLogic)
    {
        $this->productoLogic = $productoLogic;
    }

    public function getAll()
    {
        $productos = $this->productoLogic->getAll();
        return response()->$productos;
    }

    public function getByCodigo($id)
    {
        return $this->productoLogic->getByCodigo($id);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|max:20|unique:producto',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:500',
                'precio' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }

        return $this->productoLogic->create($request->codigo, $request->nombre, $request->descripcion, $request->precio, $request->stock);
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

        return $this->productoLogic->update($request->codigo, $request->nombre, $request->descripcion, $request->precio, $request->stock);
    }

    public function destroy($id)
    {
        return $this->productoLogic->delete($id);
    }
}