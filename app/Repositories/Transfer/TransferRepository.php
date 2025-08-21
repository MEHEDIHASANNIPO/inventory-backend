<?php

namespace App\Repositories\Transfer;

use App\Models\Product;
use App\Models\Transfer;
use Illuminate\Support\Str;

class TransferRepository implements TransferInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Transfer::with(['product', 'fromWarehouse', 'toWarehouse'])
        ->latest('id')
        ->select(['id', 'product_id', 'from_warehouse_id', 'to_warehouse_id', 'created_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Transfer::with(['product', 'fromWarehouse', 'toWarehouse'])
        ->latest('id')
        ->when(request('date'), function($query, $date) {
            $query->whereDate('created_at', $date);
        })
        ->when(request('warehouse'), function($query) {
            $query->where('to_warehouse_id', request('warehouse'));
        })
        ->when(request('search'), function($query) {
            $query->where('created_at', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'product_id', 'from_warehouse_id', 'to_warehouse_id', 'created_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        foreach ($requested_data->products as $product) {
            $getProduct = Product::findOrFail($product['id']);

            $data = Transfer::create([
                'product_id'  => $product['id'],
                'from_warehouse_id'  => $product['warehouse_id'],
                'to_warehouse_id'  => $requested_data->warehouse_id
            ]);

            $getProduct->update([
                'warehouse_id' => $requested_data->warehouse_id
            ]);

        }

        return $this->show($data->id);

    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Transfer::findOrFail($id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function delete($id) {
        $data = $this->show($id);
        $getProduct = Product::findOrFail($data->product_id);

        $getProduct->update([
            'warehouse_id' => $data->from_warehouse_id
        ]);
        $data->delete();

        return true;
    }
}
