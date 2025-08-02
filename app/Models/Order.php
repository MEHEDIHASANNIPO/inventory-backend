<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //

    use SoftDeletes;

    protected $guarded = ['id'];

    // Relationship
    public function orderDetails() : HasMany {
        return $this->hasMany(OrderDetail::class);
    }

    public function customer() : HasOne {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
