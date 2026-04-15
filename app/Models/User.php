<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'activo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean', // Asegura que se trate como true/false
        ];
    }

    /**
     * Relación con el modelo Role.
     * Un usuario pertenece a un Rol.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Comprueba si el usuario es Administrador.
     */
    public function isAdmin(): bool
    {
        // Comprobamos por ID y por nombre para mayor seguridad
        return $this->role_id === 1 || ($this->role && $this->role->nombre === 'Admin');
    }

    /**
     * Comprueba si el usuario es Técnico.
     */
    public function isTecnico(): bool
    {
        return $this->role_id === 2 || ($this->role && $this->role->nombre === 'Técnico');
    }

    /**
     * Comprueba si el usuario tiene permiso para acceder al panel técnico.
     * (Tanto admins como técnicos pueden entrar al taller)
     */
    public function canAccessTaller(): bool
    {
        return $this->isAdmin() || $this->isTecnico();
    }
}

