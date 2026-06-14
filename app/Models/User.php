<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements PasskeyUser
{
    use SoftDeletes;
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;
    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'address',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'date_joined' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    
    public function isEmployee(): bool
    {
        return in_array($this->role, ['employee', 'admin']);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (!$user->date_joined) {
                $user->date_joined = now();
            }

            if ($user->is_blocked === null) {
                $user->is_blocked = false;
            }
            
            if (!$user->role) {
                $user->role = 'user';
            }
        });
    }

    public function adoptionRequests()
    {
        return $this->hasMany(\App\Models\Adoption::class, 'user_id');
    }

    public function shelterVisits()
    {
        return $this->hasMany(\App\Models\Visit::class, 'user_id');
    }
}