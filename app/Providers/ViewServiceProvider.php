<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Slider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
                View::composer('*', function ($view) {

            $sliders = Slider::where('status',1)
                        ->orderBy('order')
                        ->get();

            $view->with('globalSliders', $sliders);
        });
    }
}
