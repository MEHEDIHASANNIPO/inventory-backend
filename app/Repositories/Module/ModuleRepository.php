<?php

namespace App\Repositories\Module;

use App\Models\Module;
use Illuminate\Support\Str;

class ModuleRepository implements ModuleInterface
{
    /*
     * @return mixed|void
     */

    public function all() {
        $data = Module::latest('id')
        ->select(['id', 'module_name', 'module_slug', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */

    public function allPaginate($perPage) {
        $data = Module::latest('id')
        ->when(request('search'), function($query) {
            $query->where('module_name', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'module_name', 'module_slug', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */

    public function store($requested_data) {
        $data = Module::create([
            'module_name' => $requested_data->module_name,
            'module_slug' => Str::slug($requested_data->module_name),
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */

    public function show($id) {
        return Module::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */

    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'module_name' => $requested_data->module_name,
            'module_slug' => Str::slug($requested_data->module_name),
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
}
