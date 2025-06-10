<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recepcionista extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'recepcionista';
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

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'idRecepcionista', 'cedula');
    }
}