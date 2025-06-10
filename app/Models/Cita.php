<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'codigo', 'idCliente', 'idRecepcionista', 'fechaCita', 'estado', 'costoTotal',
    ];

    // Convertir fechaCita a objeto Carbon
    protected $casts = [
        'fechaCita' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'idCliente', 'cedula');
    }

    public function recepcionista(): BelongsTo
    {
        return $this->belongsTo(Recepcionista::class, 'idRecepcionista', 'cedula');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'contieneCita', 'codigoCita', 'codigoServicio');
        // ->withTimestamps(); // Descomenta si añade timestamps a 'contieneCita'
    }
}