<?php

namespace App\Repositories;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Event;
use App\Repositories\Interfaces\ICartRepository;
use Illuminate\Support\Facades\Log;

class CartRepository implements ICartRepository
{

    public function show($cart_id)
    {
        $cart_items = CartItem::with('event')->where('cart_id', $cart_id)->get();
    }
    public function addToCart(CartRequest $request)
    {

        if (isset($request['cart_id'])) {
            // se è impostato il cart nella request correttamente recupero il cart interessato
            $cart_id = Cart::find($request['cart_id'])->id;
        } else {
            // se non è impostato nella request ne creo uno nuovo
            $cart = new Cart();
            $cart->save();
            $cart_id = $cart->id;
        }

        $cart_item = CartItem::where([
            ['event_id', '=', $request['event_id']],
            ['cart_id', '=', $cart_id]
        ])->first();

        if ($cart_item) {
            $cart_item->quantity = $cart_item->quantity + $request['quantity'];

            $cart_item->save();
        } else {
            $cart_item = CartItem::create(['cart_id' => $cart_id, 'event_id' => $request['event_id'], 'quantity' => $request['quantity']]);
        }

        $event = Event::find($request['event_id']);

        $event->available_tickets = $event->available_tickets - $request['quantity'];

        $event->save();
        $cart_item->load('event');
        return $cart_item;
    }
    public function removeToCart(CartRequest $request)
    {
        $cart_item = CartItem::where([
            ['event_id', '=', $request['event_id']],
            ['cart_id', '=', $request['cart_id']]
        ])->first();

        $cart_item->quantity = $cart_item->quantity - $request['quantity'];
        $event = Event::find($request['event_id']);
        $event->available_tickets = $event->available_tickets + $request['quantity'];
        if ($cart_item->quantity <= 0) {
            $cart_item->quantity = 0;
            $cart_item->save();
            $cart_item->delete();
        } else {
            $cart_item->save();
        }
        return $cart_item;
    }
    public function emptyCart() {}
}
