<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\User\UserInterface;

class UserController extends Controller
{
    use ApiResponse;
    private $userRepository;

    public function __construct(UserInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allUsers()
    {
        $data = $this->userRepository->all();
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a listing of the resource with pagination.
     */
    public function index()
    {
        Gate::authorize('index-user');

        $perPage = request('per_page');
        $data = $this->userRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create-user');

        try {
            $data = $this->userRepository->store($request);
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
        $data = $this->userRepository->show($id);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        Gate::authorize('edit-user');

        try {
            $data = $this->userRepository->update($request, $id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-user');

        try {
            $data = $this->userRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Update the status of the resource.
     */
    public function status(string $id)
    {
        Gate::authorize('edit-user');

        try {
            $data = $this->userRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
