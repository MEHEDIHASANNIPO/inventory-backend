<?php

namespace App\Repositories\WareHouse;

use App\Models\WareHouse;
use Illuminate\Support\Str;

class WareHouseRepository implements WareHouseInterface
{
    /*
     * @return mixed|void
     */
    public function all()
    {
        $data = WareHouse::latest('id')
            ->select(['id', 'warehouse_name', 'warehouse_address', 'warehouse_zipcode', 'warehouse_phone', 'is_active', 'updated_at'])
            ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage)
    {
        $data = WareHouse::latest('id')
            ->when(request('search'), function ($query) {
                $query->where('warehouse_name', 'like', '%' . request('search') . '%')
                    ->orWhere('warehouse_address', 'like', '%' . request('search') . '%')
                    ->orWhere('warehouse_zipcode', 'like', '%' . request('search') . '%')
                    ->orWhere('warehouse_phone', 'like', '%' . request('search') . '%');
            })
            ->select(['id', 'warehouse_name', 'warehouse_address', 'warehouse_zipcode', 'warehouse_phone', 'is_active', 'updated_at'])
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data)
    {
        $data = WareHouse::create([
            'warehouse_name'     => $requested_data->warehouse_name,
            'warehouse_slug'     => Str::slug($requested_data->warehouse_name),
            'warehouse_address'  => $requested_data->warehouse_address,
            'warehouse_zipcode'  => $requested_data->warehouse_zipcode,
            'warehouse_phone'    => $requested_data->warehouse_phone,
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id)
    {
        return WareHouse::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id)
    {
        $data = $this->show($id);

        $data->update([
            'warehouse_name'     => $requested_data->warehouse_name,
            'warehouse_slug'     => Str::slug($requested_data->warehouse_name),
            'warehouse_address'  => $requested_data->warehouse_address,
            'warehouse_zipcode'  => $requested_data->warehouse_zipcode,
            'warehouse_phone'    => $requested_data->warehouse_phone,
        ]);

        return $data;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();

        return true;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function status($id)
    {
        $data = $this->show($id);

        if ($data->is_active == 0) {
            $data->is_active = 1;
        } elseif ($data->is_active == 1) {
            $data->is_active = 0;
        }

        $data->save();

        return $data;
    }
}
