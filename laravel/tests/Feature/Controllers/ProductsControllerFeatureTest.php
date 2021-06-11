<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class ProductsControllerFeatureTest extends TestCase
{
    public function testProductsControllerGetReturnsStatus200WithCorrectCall(): void
    {
        $response = $this->call('GET', 'http://127.0.0.1:8000/api/products/recommended/kaunas');
        $response->assertStatus(200);
    }
    public function testProductsControllerGetReturnsStatus404WithWrongCityCall(): void
    {
        $response = $this->call('GET', 'http://127.0.0.1:8000/api/products/recommended/kaunasdd');
        $response->assertStatus(404);
    }
}
