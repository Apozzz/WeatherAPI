<?php

namespace Tests\Unit\Services;

use App\Exceptions\WeatherTypeNotInDataBaseException;
use App\Services\WeatherService\APIInterface;
use App\Services\ProductRecommendationService;
use Tests\TestCase;
use Mockery;

class ProductsRecommendationServiceTest extends TestCase
{
    public function testProductsRecommendationServiceThrowsWeatherTypeNotInDataBaseException(): void
    {
        $apiInterface = Mockery::mock(APIInterface::class);
        $apiInterface->shouldReceive('getProcessedAPIData')
                     ->andReturn($this->getWrongDataArray());

        $service = new ProductRecommendationService($apiInterface);
        $this->expectException(WeatherTypeNotInDataBaseException::class);
        $service->getServiceData('Kaunas');
    }

    /**
     * @throws WeatherTypeNotInDataBaseException
     */
    public function testProductsRecommendationServiceReturnsArray(): void
    {
        $apiInterface = Mockery::mock(APIInterface::class);
        $apiInterface->shouldReceive('getProcessedAPIData')
            ->andReturn($this->getCorrectDataArray());
        $service = new ProductRecommendationService($apiInterface);
        $this->assertIsArray($service->getServiceData('Kaunas'));
    }
    private function getWrongDataArray(): array
    {
        return ['place' => 'Kaunas',
            0 => ['clear' => '2021-06-07'],
            1 => ['overcast' => '2021-06-08'],
            2 => ['unknown' => '2021-06-09']
        ];
    }
    private function getCorrectDataArray(): array
    {
        return ['place' => 'Kaunas',
            0 => ['clear' => '2021-06-07'],
            1 => ['overcast' => '2021-06-08'],
            2 => ['light-rain' => '2021-06-09']
        ];
    }
}
