<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Category::latest('id')
        ->select(['id', 'category_name', 'category_slug', 'category_code', 'is_active', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Category::latest('id')
        ->when(request('search'), function($query) {
            $query->where('category_name', 'like', '%' . request('search') . '%')
                ->orWhere('category_code', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'category_name', 'category_slug', 'category_code', 'is_active', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = Category::create([
            'category_name'  => $requested_data->category_name,
            'category_slug'  => Str::slug($requested_data->category_name),
            'category_code'  => uniqid() . rand(99, 9999)
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Category::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'category_name' => $requested_data->category_name,
            'category_slug' => Str::slug($requested_data->category_name),
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
