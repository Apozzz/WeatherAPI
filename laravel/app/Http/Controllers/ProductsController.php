<?php

namespace App\Http\Controllers;

use App\Caching\ProductsCache;
use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherTypeNotInDataBaseException;
use App\Services\ProductRecommendationService;
use App\Services\WeatherService\DayTypeWeatherService;
use App\Services\WeatherService\MeteoApiClient;
use Illuminate\Contracts\View\View;

class ProductsController extends Controller
{
    protected ProductsCache $cache;

    public function __construct()
    {
        $this->cache = new ProductsCache(new ProductRecommendationService(new DayTypeWeatherService(new MeteoApiClient())));
    }

    /**
     * Function that returns View of Json format array, that is processed from initial API data
     * to the structured one.
     * @param string $city
     * @return View
     */
    public function show(string $city): View
    {
        try {
            return view('products.productJson', [
                'json' => json_encode(
                    $this->cache->cache($city), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                ),
            ]);
        } catch (CityNotFoundException | CannotConnectToMeteoAPIException | WeatherTypeNotInDataBaseException $e) {
            return $e->render($e->getMessage());
        }
    }
}
