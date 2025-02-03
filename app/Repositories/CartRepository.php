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
        $cart_item = CartItem::with('event')->where('cart_id', $cart_id)->get();
        return $cart_item;
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

        $event = Event::findOrFail($request['event_id']);

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
        ])->firstOrFail();

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
        //controllo se il cart ha ancora elementi

        $cartHasItems = CartItem::where('cart_id', $request['cart_id'])->exists();

        if (!$cartHasItems) {
            Cart::find($request['cart_id'])->delete();
        }


        return $cart_item;
    }
    public function emptyCart($cart_id)
    {
        // Recuperiamo tutti gli elementi del carrello in una singola query
        $cart_items = CartItem::where('cart_id', $cart_id)->get();

        // Creiamo un array associativo per aggregare il numero di biglietti per ogni evento
        $eventQuantities = $cart_items->pluck('quantity', 'event_id'); // [event_id => quantity]

        // Aggiorniamo tutti gli eventi in un'unica query
        Event::whereIn('id', $eventQuantities->keys())->get()->each(function ($event) use ($eventQuantities) {
            $event->increment('available_tickets', $eventQuantities[$event->id]);
        });

        // Eliminiamo tutti gli elementi del carrello in un'unica operazione
        CartItem::where('cart_id', $cart_id)->delete();
        Cart::find($cart_id)->delete();
        return $cart_items;
    }
}
