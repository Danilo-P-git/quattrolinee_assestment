<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Event",
 *     title="Evento",
 *     description="Schema di un evento",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Concerto Jazz"),
 *     @OA\Property(property="description", type="string", example="Concerto jazz dal vivo"),
 *     @OA\Property(property="length", type="number", format="float", example=3.0),
 *     @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-15 21:00:00"),
 * )
 */
class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['name', 'description', 'length', 'start_date'];
}
