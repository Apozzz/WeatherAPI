<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\WeatherTypeNotInDataBaseException;
use App\Services\ProductRecommendationService;
use App\Services\WeatherService\APIInterface;
use Tests\TestCase;
use Mockery;

class WeatherTypeNotInDataBaseExceptionTest extends TestCase
{
    public function testWeatherTypeNotInDataBaseException(): void
    {
        $apiInterface = Mockery::mock(APIInterface::class);
        $apiInterface->shouldReceive('getProcessedAPIData')
            ->andReturn($this->getWrongDataArray());

        $service = new ProductRecommendationService($apiInterface);
        $this->expectException(WeatherTypeNotInDataBaseException::class);
        $service->getServiceData('Vilnius');
    }

    private function getWrongDataArray(): array
    {
        return ['place' => 'Vilnius',
            0 => ['clear' => '2021-06-07'],
            1 => ['overcast' => '2021-06-08'],
            2 => ['unknown' => '2021-06-09']
        ];
    }
}
