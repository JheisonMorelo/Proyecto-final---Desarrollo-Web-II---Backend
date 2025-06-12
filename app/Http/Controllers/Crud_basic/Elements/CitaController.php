<?php

namespace App\Http\Controllers\Crud_basic\Elements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CitaLogic;
use Illuminate\Validation\ValidationException;

class CitaController extends Controller
{
    protected $citaLogic;

    public function __construct(CitaLogic $citaLogic)
    {
        $this->citaLogic = $citaLogic;
    }

    public function getAll()
    {
        return $this->citaLogic->getAll();
    }

    public function getByCodigo(Request $request)
    {
        return $this->citaLogic->getByCodigo($request->codigo);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|max:20|unique:cita,codigo',
                'idCliente' => 'required|string|exists:cliente,cedula',
                'idRecepcionista' => 'required|string|exists:recepcionista,cedula',
                'fechaCita' => 'required|date',
                'estado' => 'required|string|max:50',
                'costoTotal' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }
        return $this->citaLogic->create(
            $request->codigo,
            $request->idCliente,
            $request->idRecepcionista,
            $request->fechaCita,
            $request->estado,
            $request->costoTotal
        );
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|exists:cita,codigo',
                'idCliente' => 'required|string|exists:cliente,cedula',
                'idRecepcionista' => 'required|string|exists:recepcionista,cedula',
                'fechaCita' => 'required|date',
                'estado' => 'required|string|max:50',
                'costoTotal' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        }
        return $this->citaLogic->update(
            $request->codigo,
            $request->idCliente,
            $request->idRecepcionista,
            $request->fechaCita,
            $request->estado,
            $request->costoTotal
        );
    }

    public function destroy(Request $request)
    {
        return $this->citaLogic->delete($request->codigo);
    }
}
