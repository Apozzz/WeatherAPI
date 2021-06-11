<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Weather;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Product::factory(13)->create();

        // Seeding Weathers table with predefined weather types.
        foreach ($this->getWeatherData() as $weather) {
            Weather::create(['name' => $weather]);
        }

        // Seeding many-to-many relation table. Every product gets 1-3 random weather types
        // assigned.
        $weathers = Weather::all();
        Product::all()->each(function ($product) use ($weathers) {
            $product->weathers()->attach(
                $weathers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }

    /**
     * Function that returns hardcoded weathers data array to be seeded.
     * @return string[]
     */
    protected function getWeatherData(): array
    {
        return [
            0 => 'clear',
            1 => 'isolated-clouds',
            2 => 'scattered-clouds',
            3 => 'overcast',
            4 => 'light-rain',
            5 => 'moderate-rain',
            6 => 'heavy-rain',
            7 => 'sleet',
            8 => 'light-snow',
            9 => 'moderate-snow',
            10 => 'heavy-snow',
            11 => 'fog',
            12 => 'na'
        ];
    }
}
