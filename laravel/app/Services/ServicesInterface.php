<?php declare(strict_types=1);

namespace App\Services;

interface ServicesInterface
{
    public function getServiceData(string $city): array;
}
