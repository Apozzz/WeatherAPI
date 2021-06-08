<?php

namespace Tests\Unit\Services\WeatherService;

use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;
use App\Services\WeatherService\MeteoApiClient;
use Tests\TestCase;
use App\Services\WeatherService\DayTypeWeatherService;
use Mockery;

class DayTypeWeatherServiceTest extends TestCase
{
    /**
     * @throws CannotConnectToMeteoAPIException
     * @throws CityNotFoundException
     */
    public function testDayTypeWeatherServiceGetMethod(): void
    {
        $meteoMock = Mockery::mock(MeteoApiClient::class);
        $meteoMock->shouldReceive('callAPI')->andReturn($this->getDataArray());
        $weatherService = new DayTypeWeatherService($meteoMock);
        $this->assertSame([
            'place' => 'Kaunas',
            0 => ['clear' => '2021-06-07'],
            1 => ['overcast' => '2021-06-08'],
            2 => ['heavy-snow' => '2021-06-09']
        ],
            $weatherService->getProcessedAPIData('Kaunas'));
    }
    private function getDataArray(): array
    {
        return [
            'place' => [
                'name' => 'Kaunas'
            ],
            'forecastTimestamps' => [
                [
                    'forecastTimeUtc' => '2021-06-07 21:00:00',
                    'conditionCode' => 'clear'
                ],
                [
                    'forecastTimeUtc' => '2021-06-08 21:00:00',
                    'conditionCode' => 'overcast'
                ],
                [
                    'forecastTimeUtc' => '2021-06-09 21:00:00',
                    'conditionCode' => 'heavy-snow'
                ]
            ]
        ];
    }
}
