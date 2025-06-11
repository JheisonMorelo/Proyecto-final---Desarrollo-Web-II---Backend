<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];

    // Si necesitas relaciones, agrégalas aquí
}