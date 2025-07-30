<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Category\CategoryInterface;

class CategoryController extends Controller
{
    use ApiResponse;
    private $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allCategories()
    {
        $data = $this->categoryRepository->all();
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
        Gate::authorize('index-category');

        $perPage = request('per_page');
        $data = $this->categoryRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create-category');

        try {
            $data = $this->categoryRepository->store($request);
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
        $data = $this->categoryRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        Gate::authorize('edit-category');

        try {
            $data = $this->categoryRepository->update($request, $id);
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
        Gate::authorize('delete-category');

        try {
            $data = $this->categoryRepository->delete($id);
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
        Gate::authorize('edit-category');

        try {
            $data = $this->categoryRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
