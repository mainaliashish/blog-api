<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test listing all categories.
     *
     * @return void
     */
    public function test_index_returns_categories()
    {
        Category::factory()->create(['name' => 'Category 1']);
        Category::factory()->create(['name' => 'Category 2']);
        Category::factory()->create(['name' => 'Category 3']);

        // Send a GET request to the categories endpoint
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['name' => 'Category 1'])
            ->assertJsonFragment(['name' => 'Category 2'])
            ->assertJsonFragment(['name' => 'Category 3']);
    }
}
