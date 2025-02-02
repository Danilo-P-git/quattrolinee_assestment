<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Category",
 *     title="Categoria",
 *     description="Schema di una categoria",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Rock")
 * )
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['name'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
