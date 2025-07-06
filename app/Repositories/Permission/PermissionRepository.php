<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionRepository implements PermissionInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Permission::with('module:id,module_name')
        ->latest('id')
        ->select(['id', 'permission_name', 'permission_slug', 'module_id', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Permission::with('module:id,module_name')
        ->latest('id')
        ->when(request('search'), function($query) {
            $query->where('permission_name', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'permission_name', 'permission_slug', 'module_id', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = Permission::create([
            'permission_name' => $requested_data->permission_name,
            'permission_slug' => Str::slug($requested_data->permission_name),
            'module_id' => $requested_data->module_id,
        ]);

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Permission::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'permission_name' => $requested_data->permission_name,
            'permission_slug' => Str::slug($requested_data->permission_name),
            'module_id' => $requested_data->module_id,
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
