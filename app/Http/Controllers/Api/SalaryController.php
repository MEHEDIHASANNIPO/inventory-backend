<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use App\Repositories\Salary\SalaryInterface;

class SalaryController extends Controller
{
    use ApiResponse;
    private $salaryRepository;

    public function __construct(SalaryInterface $salaryRepository) {
        $this->salaryRepository = $salaryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allSalaries()
    {
        $data = $this->salaryRepository->all();
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index-salary');

        $perPage = request('per_page');
        $data = $this->salaryRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalaryRequest $request)
    {
        Gate::authorize('create-salary');

        try {
            /** Check Already Paid or Not */
            $check = Salary::where(['staff_id' => $request->staff_id, 'month' => $request->month, 'year' => $request->year])->count();

            if ($check == 0) {
                $data = $this->salaryRepository->store($request);
                return $this->ResponseSuccess($data, null, 'Data Stored Successfully!', 201);
            }

            return $this->ResponseError($check, null, 'Already Paid!', 400);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->salaryRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalaryRequest $request, string $id)
    {
        Gate::authorize('edit-salary');

        try {
            $data = $this->salaryRepository->update($request, $id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-salary');

        try {
            $data = $this->salaryRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
