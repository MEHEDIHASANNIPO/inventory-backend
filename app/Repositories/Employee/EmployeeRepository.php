<?php
namespace App\Repositories\Employee;

use App\Enums\UserRole;
use App\Models\User as Employee;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository implements EmployeeInterface
{
    private $filePaths = 'employee';
    /*
     * @return mixed|void
     */
    public function all()
    {
        $data = Employee::employee()
            ->latest('id')
            ->select(['id', 'name', 'email', 'phone', 'nid', 'address', 'file', 'is_active', 'updated_at'])
            ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage)
    {
        $data = Employee::employee()
            ->latest('id')
            ->when(request('search'), function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('nid', 'like', '%' . request('search') . '%')
                    ->orWhere('address', 'like', '%' . request('search') . '%');
                });
            })
            ->select(['id', 'name', 'email', 'phone', 'nid', 'address', 'file', 'is_active', 'updated_at'])
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data)
    {
        $data = Employee::create([
            'role_id'      => UserRole::EMPLOYEE,
            'name'         => $requested_data->name,
            'email'        => $requested_data->email,
            'phone'        => $requested_data->phone,
            'nid'          => $requested_data->nid,
            'address'      => $requested_data->address,
            'password'     => Hash::make('1234'),
        ]);

        // File Upload
        if($requested_data->file != null) {
            $filePath = (new FileUploadService())->imageUpload($requested_data, $data, $this->filePaths);

            $data->update([
                'file' => $filePath
            ]);
        }

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id)
    {
        return Employee::findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id)
    {
        $data = $this->show($id);

        $data->update([
            'name'         => $requested_data->name,
            'email'        => $requested_data->email,
            'phone'        => $requested_data->phone,
            'nid'          => $requested_data->nid,
            'address'      => $requested_data->address,
        ]);

        // File Upload
        if($requested_data->file != null) {
            $filePath = (new FileUploadService())->imageUpload($requested_data, $data, $this->filePaths);

            $data->update([
                'file' => $filePath
            ]);
        }

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
