<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Weather;

class WeatherModelTest extends TestCase
{
    public function testWeatherModelExists(): void
    {
        $this->assertInstanceOf(Weather::class, new Weather());
    }

    public function testWeatherHasName(): void
    {
        $weather = new Weather;
        $weather->name = 'Random_Weather';
        $weather->save();
        $this->assertEquals('Random_Weather', $weather->name);
        Weather::where('name', '=', 'Random_Weather')->delete();
    }
}
