<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Repositories\Module\ModuleInterface;

class ModuleController extends Controller
{
    use ApiResponse;
    private $moduleRepository;

    public function __construct(ModuleInterface $moduleRepository) {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allModules()
    {
        $data = $this->moduleRepository->all();
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
        Gate::authorize('index-module');

        $perPage = request('per_page');
        $data = $this->moduleRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleRequest $request)
    {
        Gate::authorize('create-module');

        try {
            $data = $this->moduleRepository->store($request);
            return $this->ResponseSuccess($data, null, 'Data Stored Successfully!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->moduleRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, string $id)
    {
        Gate::authorize('edit-module');

        try {
            $data = $this->moduleRepository->update($request, $id);
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
        Gate::authorize('delete-module');

        try {
            $data = $this->moduleRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
