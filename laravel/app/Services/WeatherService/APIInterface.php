<?php declare(strict_types=1);

namespace App\Services\WeatherService;

interface APIInterface
{
    public function getProcessedAPIData(string $city): array;
}
