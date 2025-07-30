<?php

namespace App\Repositories\Salary;

use App\Models\User;
use App\Models\Salary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SalaryDisburseNotification;

class SalaryRepository implements SalaryInterface
{
    /*
     * @return mixed|void
     */
    public function all() {
        $data = Salary::with('staff:id,name')
        ->latest('id')
        ->select(['id', 'staff_id', 'amount', 'date', 'month', 'year', 'type', 'updated_at'])
        ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Salary::with('staff:id,name')
        ->latest('id')
        ->when(request('date'), function($query) {
            $query->where(['date' => request('date')]);
        })
        ->when(request('month'), function($query) {
            $query->where(['month' => request('month')]);
        })
        ->when(request('year'), function($query) {
            $query->where(['year' => request('year')]);
        })
        ->when(request('type'), function($query) {
            $query->where(['type' => request('type')]);
        })
        ->when(request('search'), function($query) {
            $query->where('amount', 'like', '%' . request('search') . '%')
                ->orWhere('date', 'like', '%' . request('search') . '%')
                ->orWhere('month', 'like', '%' . request('search') . '%')
                ->orWhere('year', 'like', '%' . request('search') . '%')
                ->orWhere('type', 'like', '%' . request('search') . '%');
        })
        ->select(['id', 'staff_id', 'amount', 'date', 'month', 'year', 'type', 'updated_at'])
        ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        $data = Salary::create([
            'staff_id' => $requested_data->staff_id,
            'amount' => $requested_data->amount,
            'date' => $requested_data->date,
            'month' => $requested_data->month,
            'year' => $requested_data->year,
            'type' => $requested_data->type,
        ]);

        /* Send Notifications To Admin and Staff */
        $admins = User::admin()->get();
        $staff = User::findOrFail($requested_data->staff_id);

        $details = [
            'subject' => "Salary Disbursed for the $data->month / $data->year",
            'message' => "Dear $staff->name,
            Your Salary for the month: $data->month / $data->year has been disbursed. Please collect the cheque from account department.",
        ];

        Notification::send($admins, new SalaryDisburseNotification($details));
        Notification::send($staff, new SalaryDisburseNotification($details));

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Salary::with('staff:id,name')->findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id) {
        $data = $this->show($id);

        $data->update([
            'staff_id' => $requested_data->staff_id,
            'amount' => $requested_data->amount,
            'date' => $requested_data->date,
            'month' => $requested_data->month,
            'year' => $requested_data->year,
            'type' => $requested_data->type,
        ]);

        /* Send Notifications To Admin and Staff */
        $admins = User::admin()->get();
        $staff = User::findOrFail($requested_data->staff_id);

        $details = [
            'subject' => "Salary Disbursed for the $data->month / $data->year",
            'message' => "Dear $staff->name,
            Your Salary for the month: $data->month / $data->year has been disbursed. Please collect the cheque from account department.",
        ];

        Notification::send($admins, new SalaryDisburseNotification($details));
        Notification::send($staff, new SalaryDisburseNotification($details));

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
