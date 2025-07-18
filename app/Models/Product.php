<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\WareHouse;
use App\Models\user as Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
    }
    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class);
    }
    public function supplier() : BelongsTo {
        return $this->belongsTo(Supplier::class, 'user_id');
    }
    public function warehouse() : BelongsTo {
        return $this->belongsTo(WareHouse::class);
    }
}
