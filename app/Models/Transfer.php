<?php

namespace App\Models;

use App\Models\Product;
use App\Models\WareHouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    //

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function fromWarehouse() : BelongsTo {
        return $this->belongsTo(WareHouse::class, 'from_warehouse_id');
    }
    public function toWarehouse() : BelongsTo {
        return $this->belongsTo(WareHouse::class, 'to_warehouse_id');
    }
}
