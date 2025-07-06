<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function users() : HasMany {
        return $this->hasMany(User::class);
    }

    public function permissions() : BelongsToMany {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }
}
