<?php

namespace App\Http\Controllers\Crud_basic\Elements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\pedidoLogic;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    protected $pedidoLogic;

    public function __construct(pedidoLogic $pedidoLogic)
    {
        $this->pedidoLogic = $pedidoLogic;
    }

    public function getAll()
    {
        return $this->pedidoLogic->getAll();
    }

    public function getByCodigo(Request $request)
    {
        return $this->pedidoLogic->getByCodigo($request->codigo);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|max:20|unique:pedido,codigo',
                'idCliente' => 'required|string|exists:cliente,cedula',
                'idAsistenteVentas' => 'required|string|exists:asistente_ventas,cedula',
                'direccion' => 'required|string|max:255',
                'fechaRegistro' => 'required|date',
                'estado' => 'required|string|max:50',
                'costoTotal' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }
        return $this->pedidoLogic->create(
            $request->codigo,
            $request->idCliente,
            $request->idAsistenteVentas,
            $request->direccion,
            $request->fechaRegistro,
            $request->estado,
            $request->costoTotal
        );
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|exists:pedido,codigo',
                'idCliente' => 'required|string|exists:cliente,cedula',
                'idAsistenteVentas' => 'required|string|exists:asistente_ventas,cedula',
                'direccion' => 'required|string|max:255',
                'fechaRegistro' => 'required|date',
                'estado' => 'required|string|max:50',
                'costoTotal' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }
        return $this->pedidoLogic->update(
            $request->codigo,
            $request->idCliente,
            $request->idAsistenteVentas,
            $request->direccion,
            $request->fechaRegistro,
            $request->estado,
            $request->costoTotal
        );
    }

    public function destroy(Request $request)
    {
        return $this->pedidoLogic->delete($request->codigo);
    }
}
