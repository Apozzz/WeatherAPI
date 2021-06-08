<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\WeatherTypeNotInDataBaseException;
use Tests\TestCase;
use Mockery;

class WeatherTypeNotInDataBaseExceptionTest extends TestCase
{
    public function testWeatherTypeNotInDataBaseException(): void
    {
        $mock = Mockery::mock();
        $mock->shouldReceive('getServiceData')->andThrow(WeatherTypeNotInDataBaseException::class);
        $this->expectException(WeatherTypeNotInDataBaseException::class);
        $mock->getServiceData();
    }
}
