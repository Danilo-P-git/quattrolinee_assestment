<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Category::factory()->count(5)->create();

        $events = Event::factory()->count(100)->create();

        Cart::factory()->count(5)->create()->each(function ($cart) use ($events) {
            // Aggiungiamo da 1 a 3 eventi al carrello
            $cart->items()->createMany(
                $events->random(rand(1, 5))->map(function ($event) {
                    return [
                        'event_id' => $event->id,
                        'quantity' => rand(1, 5),
                    ];
                })->toArray()
            );
        });
    }
}
