<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return[
            'name' => $this->faker->word(),
            'sku' => substr($this->faker->uuid, 0, 5),
            'price' => $this->faker->numberBetween(0, 9000)
        ];
    }
}
