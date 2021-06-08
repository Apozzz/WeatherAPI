<?php

namespace App\Services\WeatherService;

interface APIInterface
{
    public function getProcessedAPIData(string $city): array;
}
