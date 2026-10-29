<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'IDUsuario';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'nombre_usuario',
    'Nombres',
    'Apellido',
    'email',
    'password',
    'role',
    'rol',
    'estado',
    'Estado',
    ];
    
    

    /**
     * Los atributos que deben permanecer ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtener los atributos que deben ser casteados.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        if (!empty($this->Nombres)){
            return trim($this->Nombres . ' ' . $this->Apellido  ?? '');
        }
        return $this->nombre_usuario ?? $this->email;
    }
}

