<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\CityNotFoundException;
use App\Services\WeatherService\MeteoApiClient;
use Tests\TestCase;

class CityNotFoundExceptionTest extends TestCase
{
    public function testCityNotFoundException(): void
    {
        $this->expectException(CityNotFoundException::class);
        $meteo = new MeteoApiClient();
        $meteo->callAPI('nonexistant');
    }
}
