<?php

namespace App\Repositories\Expense;

use App\Models\Expense;
use App\Service\FileUploadService;

class ExpenseRepository implements ExpenseInterface
{
    private $filePaths = 'expense';
    /*
     * @return mixed|void
     */
    public function all()
    {
        $data = Expense::with(['category:id,category_name', 'staff:id,name'])
            ->latest('id')
            ->select(['id', 'expense_category_id', 'staff_id', 'amount', 'file', 'updated_at'])
            ->get();

        return $data;
    }

    /*
     * @return mixed|void
     */
    public function allPaginate($perPage)
    {
        $data = Expense::with(['category:id,category_name', 'staff:id,name'])
            ->latest('id')
            ->when(request('search'), function ($query) {
                $query->where('amount', 'like', '%' . request('search') . '%')
                    ->orWhere('created_at', 'like', '%' . request('search') . '%');
            })
            ->select(['id', 'expense_category_id', 'staff_id', 'amount', 'file', 'updated_at'])
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data)
    {
        $data = Expense::create([
            'expense_category_id'      => $requested_data->expense_category_id,
            'staff_id'         => $requested_data->staff_id,
            'amount'      => $requested_data->amount,
            'note'     => $requested_data->note,
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
        return Expense::with(['category:id,category_name', 'staff:id,name'])
            ->findOrFail($id);
    }

    /*
     * @params data|id
     * @return mixed|void
     */
    public function update($requested_data, $id)
    {
        $data = $this->show($id);

        $data->update([
            'expense_category_id'      => $requested_data->expense_category_id,
            'staff_id'         => $requested_data->staff_id,
            'amount'      => $requested_data->amount,
            'note'     => $requested_data->note,
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
}
