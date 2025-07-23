<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Repositories\ExpenseCategory\ExpenseCategoryInterface;

class ExpenseCategoryController extends Controller
{
    use ApiResponse;
    private $expenseCategoryRepository;

    public function __construct(ExpenseCategoryInterface $expenseCategoryRepository) {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allExpenseCategories()
    {
        $data = $this->expenseCategoryRepository->all();
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
        Gate::authorize('index-expense-category');

        $perPage = request('per_page');
        $data = $this->expenseCategoryRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseCategoryRequest $request)
    {
        Gate::authorize('create-expense-category');

        $data = $this->expenseCategoryRepository->store($request);

        try {
            return $this->ResponseSuccess($data, null, 'Data Stored Successfully!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->expenseCategoryRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseCategoryRequest $request, string $id)
    {
        Gate::authorize('edit-expense-category');

        $data = $this->expenseCategoryRepository->update($request, $id);

        try {
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-expense-category');

        $data = $this->expenseCategoryRepository->delete($id);

        try {
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Update the specified resource from storage.
     */
    public function status(string $id)
    {
        Gate::authorize('edit-expense-category');

        $data = $this->expenseCategoryRepository->status($id);

        try {
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
