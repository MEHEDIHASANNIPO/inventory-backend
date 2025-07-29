<?php

namespace App\Models;

use App\Models\User;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function category() : BelongsTo {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }
    public function staff() : BelongsTo {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
