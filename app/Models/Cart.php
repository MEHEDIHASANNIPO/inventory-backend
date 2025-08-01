<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    //

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function product() : HasOne {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
