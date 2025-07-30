<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Product\ProductInterface;

class ProductController extends Controller
{
    use ApiResponse;
    private $productRepository;

    public function __construct(ProductInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of all products.
     */
    public function allProducts()
    {
        $data = $this->productRepository->all();
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }

        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a paginated listing of the products.
     */
    public function index()
    {
        Gate::authorize('index-product');

        $perPage = request('per_page');
        $data = $this->productRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }

        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Gate::authorize('create-product');

        try {
            $data = $this->productRepository->store($request);
            return $this->ResponseSuccess($data, null, 'Data Stored Successfully!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Display the specified product.
     */
    public function show(string $id)
    {
        $data = $this->productRepository->show($id);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }

        return $this->ResponseSuccess($data);
    }

    /*
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        Gate::authorize('edit-product');

        try {
            $data = $this->productRepository->update($request, $id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-product');

        try {
            $data = $this->productRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Toggle the status of the specified product.
     */
    public function status(string $id)
    {
        Gate::authorize('edit-product');

        try {
            $data = $this->productRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Status Updated Successfully!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
