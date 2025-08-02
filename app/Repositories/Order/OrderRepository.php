<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Enums\UserRole;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class OrderRepository implements OrderInterface
{
    /*
     * @return mixed|void
     */
    public function allPaginate($perPage) {
        $data = Order::with(['orderDetails', 'customer'])
            ->latest('id')
            ->when(request('customer_id'), function($query) {
                $query->where(['customer_id' => request('customer_id')]);
            })
            ->when(request('created_at'), function($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->when(request('month'), function($query, $month) {
                $query->whereMonth('created_at', $month);
            })
            ->when(request('year'), function($query, $year) {
                $query->whereYear('created_at', $year);
            })
            ->when(request('payment'), function($query) {
                $query->where(['payment_method' => request('payment')]);
            })
            ->when(request('search'), function($query) {
                $query->where('transaction_number', 'like', '%' . request('search') . '%')
                    ->orWhere('invoice_id', 'like', '%' . request('search') . '%')
                    ->orWhere('created_at', 'like', '%' . request('search') . '%');
            })
            ->paginate($perPage);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function store($requested_data) {
        // Check Customer Already Exists
        $customer_phone = $requested_data->customer_phone;
        $customer = User::where(['phone' => $customer_phone])->first();

        if(!$customer) {
            $customer = User::create([
                'role_id' => UserRole::CUSTOMER,
                'name' => $requested_data->customer_name ?? 'Walk In Customer',
                'phone' => $requested_data->customer_phone,
                'password' => Hash::make('1234')
            ]);
        }

        $data = Order::create([
            'customer_id'  => $customer->id,
            'subtotal'  => $requested_data->subtotal,
            'discount'  => $requested_data->discount,
            'total'  => $requested_data->total,
            'transaction_number'  => $requested_data->transaction_number,
            'payment_method'  => $requested_data->payment_method,
            'invoice_id'  => uniqid() . rand(99, 9999),
        ]);

        // All Cart Items
        $carts = Cart::all();

        foreach ($carts as $key => $cart) {
            OrderDetail::create([
                'order_id' => $data->id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'price' => $cart->price,
                'subtotal' => $cart->subtotal,
            ]);

            // Decrease Product QTY
            $product = Product::find($cart->product_id)->decrement('stock', $cart->qty);
            $cart->delete();
        }

        return $this->show($data->id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function show($id) {
        return Order::with(['orderDetails', 'customer'])
            ->findOrFail($id);
    }

    /*
     * @params id
     * @return mixed|void
     */
    public function invoiceDownload($id) {
        return Order::with(['orderDetails', 'customer'])
            ->where('invoice_id', $id)->first();
    }
}
