<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EventRepository;
use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IEventRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IEventRepository::class, EventRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(ICartRepository::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
