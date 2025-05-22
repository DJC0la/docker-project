<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\TypesRole;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => TypesRole::class,
        ];
    }

    public function is_hasRole(TypesRole $role): bool
    {
        return $this->role === $role;
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'LIKE', '%'.addcslashes($name, '%_\\').'%');
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('email', 'LIKE', '%'.addcslashes($email, '%_\\').'%');
    }
}
