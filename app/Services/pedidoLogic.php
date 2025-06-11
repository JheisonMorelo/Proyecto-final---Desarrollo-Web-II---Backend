<?php

namespace App;

use App\Models\Pedido;

class pedidoLogic
{
    /**
     * Obtener todos los pedidos.
     */
    public static function getAll()
    {
        $pedidos = Pedido::all();
        return response()->json([
            'message' => 'Lista de pedidos',
            'data' => $pedidos
        ], 200);
    }

    /**
     * Obtener un pedido por su código.
     */
    public static function getByCodigo($codigo)
    {
        $pedido = Pedido::find($codigo);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        return response()->json([
            'message' => 'Pedido encontrado',
            'data' => $pedido
        ], 200);
    }

    /**
     * Crear un nuevo pedido.
     */
    public static function create($codigo, $idCliente, $idAsistenteVentas, $direccion, $fechaRegistro, $estado, $costoTotal)
    {
        $pedido = Pedido::create([
            'codigo' => $codigo,
            'idCliente' => $idCliente,
            'idAsistenteVentas' => $idAsistenteVentas,
            'direccion' => $direccion,
            'fechaRegistro' => $fechaRegistro,
            'estado' => $estado,
            'costoTotal' => $costoTotal
        ]);

        return response()->json([
            'message' => 'Pedido creado exitosamente',
            'data' => $pedido
        ], 201);
    }

    /**
     * Actualizar un pedido existente.
     */
    public static function update($codigo, $idCliente, $idAsistenteVentas, $direccion, $fechaRegistro, $estado, $costoTotal)
    {
        $pedido = Pedido::find($codigo);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->idCliente = $idCliente;
        $pedido->idAsistenteVentas = $idAsistenteVentas;
        $pedido->direccion = $direccion;
        $pedido->fechaRegistro = $fechaRegistro;
        $pedido->estado = $estado;
        $pedido->costoTotal = $costoTotal;
        $pedido->save();

        return response()->json([
            'message' => 'Pedido actualizado correctamente',
            'data' => $pedido
        ], 200);
    }

    /**
     * Eliminar un pedido por su código.
     */
    public static function delete($codigo)
    {
        $pedido = Pedido::find($codigo);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        $pedido->delete();
        return response()->json(['message' => 'Pedido eliminado correctamente'], 200);
    }
}