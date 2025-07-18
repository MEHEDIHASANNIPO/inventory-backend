<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareHouse extends Model
{
    /** @use HasFactory<\Database\Factories\WareHouseFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];
}
