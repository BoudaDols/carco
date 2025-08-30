<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Categorie;

class CarTest extends TestCase
{
    public function test_car_belongs_to_brand()
    {
        $brand = Brand::factory()->create();
        $car = Car::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $car->brand);
        $this->assertEquals($brand->id, $car->brand->id);
    }

    public function test_car_belongs_to_categorie()
    {
        $categorie = Categorie::factory()->create();
        $car = Car::factory()->create(['categorie_id' => $categorie->id]);

        $this->assertInstanceOf(Categorie::class, $car->categorie);
        $this->assertEquals($categorie->id, $car->categorie->id);
    }

    public function test_car_has_fillable_attributes()
    {
        $car = new Car();
        
        $expected = [
            'name', 'year', 'color', 'price', 
            'chassisNumber', 'description', 
            'categorie_id', 'brand_id'
        ];
        
        $this->assertEquals($expected, $car->getFillable());
    }
}