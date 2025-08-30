<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Categorie;
use App\Models\Car;
use App\Models\Brand;

class CategorieControllerTest extends TestCase
{
    public function test_can_get_all_categories()
    {
        Categorie::factory()->count(3)->create();

        $response = $this->getJson('/api/auth/categories');

        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

    public function test_can_create_categorie()
    {
        $response = $this->postJson('/api/auth/categorie/create', [
            'name' => 'SUV'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'SUV']);
    }

    public function test_cannot_create_duplicate_categorie()
    {
        Categorie::factory()->create(['name' => 'SUV']);

        $response = $this->postJson('/api/auth/categorie/create', [
            'name' => 'SUV'
        ]);

        $response->assertStatus(422);
    }

    public function test_can_get_categorie_by_id()
    {
        $categorie = Categorie::factory()->create();

        $response = $this->getJson('/api/auth/categorie/' . $categorie->id);

        $response->assertStatus(200)
                ->assertJsonStructure(['id', 'name']);
    }

    public function test_can_update_categorie()
    {
        $categorie = Categorie::factory()->create();

        $response = $this->putJson('/api/auth/categorie/' . $categorie->id, [
            'name' => 'Updated Category'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_categorie()
    {
        $categorie = Categorie::factory()->create();

        $response = $this->deleteJson('/api/auth/categorie/' . $categorie->id);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Categorie deleted']);
    }

    public function test_can_get_cars_by_categorie()
    {
        $categorie = Categorie::factory()->create(['name' => 'SUV']);
        $brand = Brand::factory()->create();
        
        Car::factory()->count(2)->create([
            'categorie_id' => $categorie->id,
            'brand_id' => $brand->id
        ]);

        $response = $this->getJson('/api/auth/categories/cars?name=SUV');

        $response->assertStatus(200)
                ->assertJsonCount(2);
    }
}