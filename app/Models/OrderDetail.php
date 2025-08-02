<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    //

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
