<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Enums\UserRole;
use Illuminate\Support\Str;

class RoleRepository implements RoleInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Role::whereNotIn('id', [UserRole::ADMIN, UserRole::EMPLOYEE, UserRole::SUPPLIER, UserRole::CUSTOMER])
        ->with('permissions:id,permission_name')
        ->select(['id', 'role_name', 'role_slug', 'role_note', 'is_deleteable', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Role::with('permissions:id,permission_name')
        ->when(request('search'), function($query) {
            $query->where('role_name', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'role_name', 'role_slug', 'role_note', 'is_deleteable', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = Role::create([
            'role_name' => $requested_data->role_name,
            'role_slug' => Str::slug($requested_data->role_name),
            'role_note' => $requested_data->role_note,
        ]);

        $data->permissions()->sync($requested_data->input('permissions', []));

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Role::with('permissions:id,permission_name,permission_slug')->findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'role_name' => $requested_data->role_name,
            'role_slug' => Str::slug($requested_data->role_name),
            'role_note' => $requested_data->role_note,
        ]);

        $data->permissions()->sync($requested_data->input('permissions', []));

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
