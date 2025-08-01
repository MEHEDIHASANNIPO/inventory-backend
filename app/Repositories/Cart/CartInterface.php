<?php

namespace App\Repositories\Cart;

interface CartInterface
{
    public function getCartItems();
    public function addToCart($date);
    public function removeFromCart($id);
    public function increaseQty($id);
    public function decreaseQty($id);
}
