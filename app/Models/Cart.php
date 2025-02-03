<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    /**
     * @OA\Schema(
     *     schema="Cart",
     *     title="Carrello",
     *     description="Schema di un carrello",
     *     @OA\Property(property="id", type="integer", example=1),
     * )
     */
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
