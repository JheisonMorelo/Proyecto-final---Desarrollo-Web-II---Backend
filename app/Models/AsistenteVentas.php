<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AsistenteVentas extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'asistenteVentas';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'cedula';

    protected $fillable = [
        'cedula', 'nombre', 'email', 'password', 'edad', 'sexo', 'salario',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}