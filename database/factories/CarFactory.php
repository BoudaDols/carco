<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'year' => $this->faker->year(),
            'price' => $this->faker->numberBetween(10000, 100000),
            'color' => $this->faker->word(),
            'chassisNumber' => $this->faker->unique()->text(10),
            'brand_id' => Brand::factory(),
            'categorie_id' => Categorie::factory(),
            'brand_id' => Brand::factory(),
            'categorie_id' => Categorie::factory(),
        ];
    }
}