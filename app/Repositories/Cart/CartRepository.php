<?php
namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;

class CartRepository implements CartInterface
{
    /*
     * @return mixed|void
     */
    public function getCartItems()
    {
        $data = Cart::with('product:id,product_name,product_code,sell_price,file')->get();

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function addToCart($requested_data)
    {
        $product_id = $requested_data->product_id;
        $product = Product::find($product_id);

        // Check if Already added on Cart
        $check = Cart::where(['product_id' => $product_id])->first();
        if($check) {
            /** If Found -> Increase Cart QTY */
            $check->increment('qty');
            $check->update([
                'subtotal' => $check->qty *  $check->price
            ]);

            return $check;
        } else {
            $data = Cart::create([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'qty' => $requested_data->qty,
                'price' => $product->sell_price,
                'subtotal' => $product->sell_price * $requested_data->qty,
            ]);

            return $data;
        }
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function removeFromCart($id)
    {
        $data = Cart::findOrFail($id);
        $data->delete();

        return true;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function increaseQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->increment('qty');

        $data->update([
            'subtotal' => $data->qty *  $data->price
        ]);

        return $data;
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function decreaseQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->decrement('qty');

        $data->update([
            'subtotal' => $data->qty *  $data->price
        ]);

        return $data;
    }
}
