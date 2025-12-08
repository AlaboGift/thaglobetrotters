<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Filter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $append = ['role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    public function scopeCustomers($query)
    {
        $query->whereHas('roles', function ($query) {
            $query->where('name', UserRole::CUSTOMER);
        });
    }

    public function scopeAdmins($query)
    {
        $query->whereHas('roles', function ($query) {
            $query->where('name', '!=', UserRole::CUSTOMER);
        });
    }

    public function getRoleAttribute()
    {
        return $this->roles()?->first()?->name;
    }

    public function isAdmin()
    {
        return $this->hasAnyRole([
            UserRole::ADMIN,
            UserRole::SUB_ADMIN,
            UserRole::MODERATOR
        ]);
    }
}
