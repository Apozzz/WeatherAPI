<?php

namespace Tests\Unit\Cache;

use App\Caching\ProductsCache;
use App\Services\ServicesInterface;
use Tests\TestCase;
use Mockery;

class ProductsCacheTest extends TestCase
{
    public function testProductsCacheStoring(): void
    {
        $servicesMock = Mockery::mock(ServicesInterface::class);
        $servicesMock->shouldReceive('getServiceData')
                    ->andReturn($this->getDataArray());


        $cache = new ProductsCache($servicesMock);
        $this->assertSame($this->getDataArray(), $cache->cache('Kaunas'));

    }

    private function getDataArray(): array
    {
        return $data = [
            'city' => 'Kaunas',
            'recommendations' => [
                'weather_forecast' => 'rain',
                'date' => '2020-04-15',
                'products' => [
                    'sku' => 'UM-1',
                    'name' => 'Umbrella',
                    'price' => '10.20'
                ]
            ]
        ];
    }
}
