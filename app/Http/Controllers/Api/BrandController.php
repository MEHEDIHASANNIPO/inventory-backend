<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Repositories\Brand\BrandInterface;

class BrandController extends Controller
{
    use ApiResponse;
    private $brandRepository;

    public function __construct(BrandInterface $brandRepository) {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allBrands()
    {
        $data = $this->brandRepository->all();
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a paginated listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index-brand');

        $perPage = request('per_page');
        $data = $this->brandRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        Gate::authorize('create-brand');

        try {
            $data = $this->brandRepository->store($request);
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
        $data = $this->brandRepository->show($id);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        Gate::authorize('edit-brand');

        try {
            $data = $this->brandRepository->update($request, $id);
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
        Gate::authorize('delete-brand');

        try {
            $data = $this->brandRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Update the status of the specified resource.
     */
    public function status(string $id)
    {
        Gate::authorize('edit-brand');

        try {
            $data = $this->brandRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
