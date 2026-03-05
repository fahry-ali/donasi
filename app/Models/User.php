<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is masyarakat.
     */
    public function isMasyarakat(): bool
    {
        return $this->role === 'masyarakat';
    }

    /**
     * Check if user is donatur.
     */
    public function isDonatur(): bool
    {
        return $this->role === 'donatur';
    }

    /**
     * Get programs created by this user.
     */
    public function programs()
    {
        return $this->hasMany(ProgramDonasi::class, 'created_by', 'id_user');
    }

    /**
     * Get proposals submitted by this user.
     */
    public function usulanPrograms()
    {
        return $this->hasMany(UsulanProgram::class, 'id_user', 'id_user');
    }

    /**
     * Get activity content created by this user.
     */
    public function kontenKegiatan()
    {
        return $this->hasMany(KontenKegiatan::class, 'created_by', 'id_user');
    }

    /**
     * Get donations made by this user.
     */
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_user', 'id_user');
    }
}
