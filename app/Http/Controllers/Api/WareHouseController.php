<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreWareHouseRequest;
use App\Http\Requests\UpdateWareHouseRequest;
use App\Repositories\WareHouse\WareHouseInterface;

class WareHouseController extends Controller
{
    use ApiResponse;
    private $wareHouseRepository;

    public function __construct(WareHouseInterface $wareHouseRepository) {
        $this->wareHouseRepository = $wareHouseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allWareHouses()
    {
        $data = $this->wareHouseRepository->all();
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
        Gate::authorize('index-warehouse');

        $perPage = request('per_page');
        $data = $this->wareHouseRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(StoreWareHouseRequest $request)
    {
        Gate::authorize('create-warehouse');

        $data = $this->wareHouseRepository->store($request);

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
        $data = $this->wareHouseRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(UpdateWareHouseRequest $request, string $id)
    {
        Gate::authorize('edit-warehouse');

        $data = $this->wareHouseRepository->update($request, $id);

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
        Gate::authorize('delete-warehouse');

        $data = $this->wareHouseRepository->delete($id);

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
        Gate::authorize('edit-warehouse');

        $data = $this->wareHouseRepository->status($id);

        try {
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
