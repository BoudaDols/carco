<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'year' => $this->faker->numberBetween(2000, 2024),
            'color' => $this->faker->colorName,
            'price' => $this->faker->numberBetween(10000, 100000),
            'chassisNumber' => $this->faker->unique()->regexify('[A-Z0-9]{17}'),
            'description' => $this->faker->sentence,
            'categorie_id' => Categorie::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}