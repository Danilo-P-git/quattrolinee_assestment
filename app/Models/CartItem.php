<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    /**
     * @OA\Schema(
     *     schema="CartItem",
     *     title="Item carrello",
     *     description="Schema di singolo item del carrello",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="cart_id", type="integer", example=1),
     *     @OA\Property(property="event_id", type="integer", example=1),
     *     @OA\Property(property="quantity", type="integer", example=1),
     *     @OA\Property(property="event", ref="#/components/schemas/Event")
     * )
     */
    use HasFactory;
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['cart_id', 'event_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
