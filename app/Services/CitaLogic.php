<?php

namespace App;

use App\Models\Cita;

class CitaLogic
{
    /**
     * Obtener todas las citas.
     */
    public static function getAll()
    {
        $citas = Cita::all();
        return response()->json([
            'message' => 'Lista de citas',
            'data' => $citas
        ], 200);
    }

    /**
     * Obtener una cita por su código.
     */
    public static function getByCodigo($codigo)
    {
        $cita = Cita::find($codigo);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        return response()->json([
            'message' => 'Cita encontrada',
            'data' => $cita
        ], 200);
    }

    /**
     * Crear una nueva cita.
     */
    public static function create($codigo, $idCliente, $idRecepcionista, $fechaCita, $estado, $costoTotal)
    {
        $cita = Cita::create([
            'codigo' => $codigo,
            'idCliente' => $idCliente,
            'idRecepcionista' => $idRecepcionista,
            'fechaCita' => $fechaCita,
            'estado' => $estado,
            'costoTotal' => $costoTotal
        ]);

        return response()->json([
            'message' => 'Cita creada exitosamente',
            'data' => $cita
        ], 201);
    }

    /**
     * Actualizar una cita existente.
     */
    public static function update($codigo, $idCliente, $idRecepcionista, $fechaCita, $estado, $costoTotal)
    {
        $cita = Cita::find($codigo);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->idCliente = $idCliente;
        $cita->idRecepcionista = $idRecepcionista;
        $cita->fechaCita = $fechaCita;
        $cita->estado = $estado;
        $cita->costoTotal = $costoTotal;
        $cita->save();

        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'data' => $cita
        ], 200);
    }

    /**
     * Eliminar una cita por su código.
     */
    public static function delete($codigo)
    {
        $cita = Cita::find($codigo);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        $cita->delete();
        return response()->json(['message' => 'Cita eliminada correctamente'], 200);
    }
}