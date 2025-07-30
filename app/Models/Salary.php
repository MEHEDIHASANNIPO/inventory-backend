<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    /** @use HasFactory<\Database\Factories\SalaryFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function staff() : BelongsTo {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
