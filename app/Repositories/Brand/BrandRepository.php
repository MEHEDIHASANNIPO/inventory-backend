<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;

class BrandRepository implements BrandInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Brand::latest('id')
            ->select(['id', 'brand_name', 'brand_slug', 'brand_code', 'is_active', 'updated_at'])
            ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Brand::latest('id')
            ->when(request('search'), function($query) {
                $query->where('brand_name', 'like', '%' . request('search') . '%')
                    ->orWhere('brand_code', 'like', '%' . request('search') . '%');
            })
            ->select(['id', 'brand_name', 'brand_slug', 'brand_code', 'is_active', 'updated_at'])
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = Brand::create([
            'brand_name'  => $requested_data->brand_name,
            'brand_slug'  => Str::slug($requested_data->brand_name),
            'brand_code'  => uniqid() . rand(99, 9999)
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Brand::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'brand_name' => $requested_data->brand_name,
            'brand_slug' => Str::slug($requested_data->brand_name),
        ]);

        return $data;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function delete($id) {
        $data = $this->show($id);
        $data->delete();

        return true;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function status($id) {
        $data = $this->show($id);

        if($data->is_active == 0) {
            $data->is_active = 1;
        } elseif($data->is_active == 1) {
            $data->is_active = 0;
        }

        $data->save();

        return $data;
    }
}
