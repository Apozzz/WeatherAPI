<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Caching\ProductsCache;
use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherTypeNotInDataBaseException;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    protected ProductsCache $cache;

    public function __construct($productsCache)
    {
        $this->cache = $productsCache;
    }

    /**
     * Function that returns View of Json format array, that is processed from initial API data
     * to the structured one.
     * @param string $city
     * @return Response
     */
    public function show(string $city): Response
    {
        try {
            return response()->view('products.productJson', [
                'json' => json_encode(
                    $this->cache->cache($city), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                ),
            ]);
        } catch (CityNotFoundException | CannotConnectToMeteoAPIException | WeatherTypeNotInDataBaseException $e) {
            return $e->render($e->getMessage());
        }
    }
}
