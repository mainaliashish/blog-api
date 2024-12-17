<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test to check the index feature for posts.
     *
     * @return void
     */
    public function test_index_returns_posts()
    {
        // Create a user and authenticate the user (assuming you have a user setup)
        $user = User::factory()->create();

        $category = Category::factory()->create();

        Post::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // Act as the user (or you can skip this if no authentication is needed)
        $this->actingAs($user);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);

        // Assert that the response contains the posts data
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'author',
                    'category',
                    'publication_date',
                ]
            ],
            'message',
        ]);
    }

    /**
     * Test to create a new post.
     */
    public function test_create_post()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $category = Category::factory()->create();

        // Data for creating a post
        $postData = [
            'title' => 'New Post Title',
            'content' => 'Content for the new post.',
            'author_id' => $user->id,
            'category_id' => $category->id,
            'publication_date' => now(),
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    /**
     * Test that if post is not found, return a 404 error.
     *
     * @return void
     */
    public function test_cannot_show_non_existent_post()
    {
        $response = $this->getJson('/api/posts/999');

        // Assert that the response status is 404 and contains the correct error message
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Post not found.',
            ]);
    }

    /**
     * Test to update a post.
     */
    public function test_update_post()
    {
        // Create a user and log in with Sanctum
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $category = Category::factory()->create();

        // Seed posts
        $post = Post::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // Data for updating a post
        $updatedPostData = [
            'title' => 'Updated Title',
            'content' => 'Updated content for the post.',
            'author_id' => $user->id,
            'category_id' => $category->id,
            'publication_date' => now(),
        ];

        $response = $this->patchJson("/api/posts/{$post->id}", $updatedPostData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }


    /**
     * Test to delete a post.
     */
    public function test_user_can_not_delete_post()
    {
        // Create a user and log in with Sanctum
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $category = Category::factory()->create();

        // Seed posts
        $post = Post::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403);
        $response->assertJson(['success' => false]);
    }


    /**
     * Test to delete a post.
     */
    public function test_admin_can_delete_post()
    {
        // Create a user and log in with Sanctum
        $user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($user);
        $category = Category::factory()->create();

        // Seed posts
        $post = Post::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
