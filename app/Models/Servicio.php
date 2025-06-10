<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'precio',
    ];

    public function citas(): BelongsToMany
    {
        return $this->belongsToMany(Cita::class, 'contieneCita', 'codigoServicio', 'codigoCita');
        // ->withTimestamps(); // Descomenta si añade timestamps a 'contieneCita'
    }
}