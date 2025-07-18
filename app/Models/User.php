<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Enums\UserRole;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'nid',
        'address',
        'company_name',
        'file',
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

    // Relationship
    public function role() : BelongsTo {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission_slug) {
        return $this->role->permissions->where('permission_slug', $permission_slug)->first() ? true : false;
    }

    // Roles
    public function scopeAdmin() {
        return $this->where(['role_id' => UserRole::ADMIN]);
    }
    public function scopeManager() {
        return $this->where(['role_id' => UserRole::MANAGER]);
    }
    public function scopeStaff() {
        return $this->where(['role_id' => UserRole::STAFF]);
    }
    public function scopeSupplier() {
        return $this->where(['role_id' => UserRole::SUPPLIER]);
    }
    public function scopeCustomer() {
        return $this->where(['role_id' => UserRole::CUSTOMER]);
    }
}
