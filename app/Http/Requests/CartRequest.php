<?php

namespace App\Http\Requests;

use App\Models\CartItem;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="CartRequest",
 *     title="Richiesta di Creazione o aggiunta di un item al carrello",
 *     description="Schema per la creazione o l'aggiunta di un prodotto al carrello",
 *     required={"event_id, quantity"},
 *     @OA\Property(property="cart_id", type="integer", example="2"),
 *     @OA\Property(property="event_id", type="integer", example="45"),
 *     @OA\Property(property="quantity", type="integer", example="25"),
 * )
 */

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return [
                'event_id' => 'required|integer|exists:events,id',
                'cart_id' => 'nullable|integer|exists:carts,id',
                'quantity' => [
                    'required',
                    'integer',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        $event = Event::find($this->event_id);
                        if ($event && $value > $event->available_tickets) {
                            $fail("La quantità richiesta ($value) supera i biglietti disponibili ({$event->available_tickets}).");
                        }
                    }
                ]
            ];
        } else if ($this->isMethod('DELETE')) {
            return [
                'event_id' => 'required|integer|exists:events,id',
                'cart_id' => 'required|integer|exists:carts,id',
                'quantity' => [
                    'required',
                    'integer',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        $cartItemQuantity = CartItem::where([
                            ['event_id', '=', $this->event_id],
                            ['cart_id', '=', $this->cart_id]
                        ])->first();

                        // $quantity = $cartItemQuantity->quantity;

                        Log::info($cartItemQuantity);
                        if (isset($cartItemQuantity) && $cartItemQuantity->quantity < $value) {
                            $fail("La quantità richiesta ($value) supera i biglietti all'interno del carrello ({$cartItemQuantity->quantity}).");
                        }
                    }
                ]
            ];
        }
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'L\'ID dell\'evento è obbligatorio.',
            'event_id.exists' => 'L\'evento selezionato non esiste.',

            'cart_id.exists' => 'Il carrello selezionato non esiste.',
            'cart_id.required' => 'L\'ID dell\'carrello è obbligatorio.',

            'quantity.required' => 'La quantità è obbligatoria.',
            'quantity.integer' => 'La quantità deve essere un numero intero.',
            'quantity.min' => 'La quantità deve essere almeno 1.'
        ];
    }
}
