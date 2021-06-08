<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;

class ProductsControllerUnitTest extends TestCase
{
    public function testProductsControllerGet(): void
    {
        $response = $this->call('GET', 'http://127.0.0.1:8000/api/products/recommended/kaunas');
        $response->assertViewIs('products.productJson');
    }
    public function testReturnsErrorViewIfCalledWithWrongCityNameInGet(): void
    {
        $response = $this->call('GET', 'http://127.0.0.1:8000/api/products/recommended/kaunasdd');
        $response->assertViewIs('errors.error');
    }
}
