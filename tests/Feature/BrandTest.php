<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_add_a_brand()
    {
        $brandData = [
            'name' => 'Test Brand',
            'origin' => 'Test Origin'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/auth/brands', $brandData);

        $response->assertStatus(201)
            ->assertJsonFragment($brandData);

        $this->assertDatabaseHas('brands', $brandData);
    }

    public function test_user_can_get_all_brands()
    {
        Brand::factory()->count(3)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/auth/brands');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_get_a_brand_by_id()
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/brands/{$brand->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $brand->name]);
    }

    public function test_user_can_update_a_brand()
    {
        $brand = Brand::factory()->create();

        $updatedData = [
            'name' => 'Updated Brand Name',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/auth/brands/{$brand->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('brands', $updatedData);
    }

    public function test_user_can_delete_a_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/auth/brands/{$brand->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function test_user_can_get_cars_by_brand()
    {
        $brand = Brand::factory()->create();
        Car::factory()->count(3)->create(['brand_id' => $brand->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/brands/{$brand->id}/cars");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
