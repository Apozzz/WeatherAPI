<?php

namespace App\Providers;

use App\Services\ProductRecommendationService;
use App\Services\WeatherService\DayTypeWeatherService;
use App\Services\WeatherService\MeteoApiClient;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\ProductsController;
use App\Caching\ProductsCache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ProductsController::class, function () {
            return new ProductsController(new ProductsCache(
                new ProductRecommendationService(
                    new DayTypeWeatherService(
                        new MeteoApiClient()))));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
