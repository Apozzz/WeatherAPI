<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductModelTest extends TestCase
{
    public function testProductModelExists(): void
    {
        $this->assertInstanceOf(Product::class, new Product());
    }

    public function testProductHasName(): void
    {
        $product = Product::factory()->create(['name' => 'Random_Name']);
        $this->assertEquals('Random_Name', $product->name);
        Product::where('name', '=', 'Random_Name')->delete();
    }
    public function testProductHasSku(): void
    {
        $product = Product::factory()->create(['sku' => 'Random_Sku']);
        $this->assertEquals('Random_Sku', $product->sku);
        Product::where('sku', '=', 'Random_Sku')->delete();
    }
    public function testProductHasPrice(): void
    {
        $product = Product::factory()->create(['price' => 6666]);
        $this->assertEquals(6666, $product->price);
        Product::where('price', '=', 6666)->delete();
    }
}
