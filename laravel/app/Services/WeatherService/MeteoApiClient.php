<?php declare(strict_types=1);

namespace App\Services\WeatherService;

use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;
use Exception;
use Illuminate\Support\Facades\Http;

class MeteoApiClient
{
    /**
     * Function that returns initial API data
     * @param string $city
     * @return array
     * @throws CityNotFoundException
     * @throws CannotConnectToMeteoAPIException
     */
    public function callAPI(string $city): array
    {
        try {
            $data = Http::get(config('meteoapi.baseUrl').$city.config('meteoapi.endPointUrl'))->json();
        } catch(Exception $e) {
            throw new CannotConnectToMeteoAPIException('Cannot connect to the Meteo API.');
        }


        if (array_key_exists('error', $data)) {
            throw new CityNotFoundException('City with the name of \''.$city.'\' can not be used.');
        }

        return $data;
    }
}
