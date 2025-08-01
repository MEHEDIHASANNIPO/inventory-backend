<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCartRequest;
use App\Repositories\Cart\CartInterface;

class CartController extends Controller
{
    use ApiResponse;
    private $cartRepository;

    public function __construct(CartInterface $cartRepository) {
        $this->cartRepository = $cartRepository;
    }

    // Get All Cart Items
    public function getCartItems() {
        Gate::authorize('index-pos');

        $data = $this->cartRepository->getCartItems();
        $metadata['count'] = count($data);
        $metadata['subtotal'] = Cart::sum('subtotal');

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found');
        }

        return $this->ResponseSuccess($data, $metadata);
    }

    // Add To Cart
    public function addToCart(StoreCartRequest $request) {
        try {
            $data = $this->cartRepository->addToCart($request);
            $metadata['subtotal'] = Cart::sum('subtotal');

            return $this->ResponseSuccess($data, $metadata, 'Cart Item Added!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    // Remove From Cart
    public function removeFromCart($id) {
        try {
            $data = $this->cartRepository->removeFromCart($id);

            return $this->ResponseSuccess($data, null, 'Cart Item Removed!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    // Increae Cart QTY
    public function increaseQty($id) {
        try {
            $data = $this->cartRepository->increaseQty($id);

            return $this->ResponseSuccess($data, null, 'Cart Item Incremented!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    // Decrease Cart QTY
    public function decreaseQty($id) {
        try {
            $data = $this->cartRepository->decreaseQty($id);

            return $this->ResponseSuccess($data, null, 'Cart Item Decremented!', 204);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
