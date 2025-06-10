<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cliente';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'cedula';

    protected $fillable = [
        'cedula', 'nombre', 'email', 'password', 'edad', 'sexo', 'fecha_nacimiento'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'idCliente', 'cedula');
    }
}