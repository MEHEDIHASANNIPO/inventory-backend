<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Repositories\Customer\CustomerInterface;

class CustomerController extends Controller
{
    use ApiResponse;
    private $customerRepository;

    public function __construct(CustomerInterface $customerRepository) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allCustomers()
    {
        $data = $this->customerRepository->all();
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index-customer');

        $perPage = request('per_page');
        $data = $this->customerRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        Gate::authorize('create-customer');

        try {
            $data = $this->customerRepository->store($request);
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
        $data = $this->customerRepository->show($id);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        Gate::authorize('edit-customer');

        try {
            $data = $this->customerRepository->update($request, $id);
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
        Gate::authorize('delete-customer');

        try {
            $data = $this->customerRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /**
     * Change status of the resource.
     */
    public function status(string $id)
    {
        Gate::authorize('edit-customer');

        try {
            $data = $this->customerRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
