<?php

namespace App\Repositories\ExpenseCategory;

use App\Models\ExpenseCategory;
use Illuminate\Support\Str;

class ExpenseCategoryRepository implements ExpenseCategoryInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = ExpenseCategory::latest('id')
        ->select(['id', 'category_name', 'category_slug', 'is_active', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = ExpenseCategory::latest('id')
        ->when(request('search'), function($query) {
            $query->where('category_name', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'category_name', 'category_slug', 'is_active', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = ExpenseCategory::create([
            'category_name'  => $requested_data->category_name,
            'category_slug'  => Str::slug($requested_data->category_name),
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return ExpenseCategory::findOrFail($id);
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
