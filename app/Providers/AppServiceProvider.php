<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Inertia::share('cartDetails', function () {
            if (!auth()->check()) {
                return [
                    'count' => 0,
                    'hasItems' => false,
                ];
            }

            $cart = auth()->user()
                ->cart()
                ->withCount('items')
                ->first();

            return [
                'count' => $cart?->items_count ?? 0,
                'hasItems' => ($cart?->items_count ?? 0) > 0,
            ];
        });
    }
}
