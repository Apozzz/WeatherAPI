<?php

namespace App\Caching;

use App\Services\ServicesInterface;
use Illuminate\Support\Facades\Cache;

class ProductsCache
{
    protected ServicesInterface $service;

    public function __construct(ServicesInterface $serviceInterface)
    {
        $this->service = $serviceInterface;
    }

    /**
     * Function that returns array from cache if it exists, if not then returns newly
     * processed one and puts it into the cache.
     * @param string $city
     * @return array
     */
    public function cache(string $city): array
    {
        $cachedData = Cache::get($city);
        if (!$cachedData) {
            $cachedData = $this->service->getServiceData($city);
            Cache::put($city, $cachedData, now()->addMinutes(5));
        }
        return $cachedData;
    }
}
