<?php

namespace App\Services;

interface ServicesInterface
{
    public function getServiceData(string $city): array;
}
