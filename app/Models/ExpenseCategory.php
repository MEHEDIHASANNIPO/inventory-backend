<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseCategoryFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];
}
