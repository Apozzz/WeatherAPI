<?php

namespace Tests\Unit\Services\WeatherService;

use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;
use App\Services\WeatherService\MeteoApiClient;
use Tests\TestCase;

class MeteoApiClientTest extends TestCase
{
    /**
     * @throws CityNotFoundException|CannotConnectToMeteoAPIException
     */
    public function testCityNotFoundExceptionInCallApiMethod(): void
    {
        $this->expectException(CityNotFoundException::class);
        $meteo = new MeteoApiClient();
        $meteo->callAPI('vilniusd');
    }

    public function testReturnsArrayIfCorrectRequest(): void
    {
        $meteo = new MeteoApiClient();
        $this->assertIsArray($meteo->callAPI('kaunas'));
    }
}
