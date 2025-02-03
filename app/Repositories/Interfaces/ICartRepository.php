<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CartRequest;

interface ICartRepository
{
    public function show($cart_id);
    public function addToCart(CartRequest $request);
    public function removeToCart();
    public function emptyCart();
}
