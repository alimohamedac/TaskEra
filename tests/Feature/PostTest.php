<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = auth()->login($this->user);
    }

    public function test_user_can_create_post()
    {
        $postData = [
            'title' => 'Test Post',
            'description' => 'This is a test post description.',
            'contact_phone' => '+1234567890',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/posts', $postData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'contact_phone',
                    'user_id',
                    'created_at',
                    'updated_at',
                    'user'
                ]
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'description' => 'This is a test post description.',
            'contact_phone' => '+1234567890',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_view_public_posts()
    {
        Post::factory(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'short_description',
                            'contact_phone',
                            'user_id',
                            'created_at',
                            'updated_at',
                            'user'
                        ]
                    ],
                    'current_page',
                    'per_page',
                    'total'
                ]
            ]);
    }

    public function test_user_can_view_single_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'contact_phone',
                    'user_id',
                    'created_at',
                    'updated_at',
                    'user'
                ]
            ]);
    }

    public function test_user_can_update_own_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $updateData = [
            'title' => 'Updated Post Title',
            'description' => 'Updated post description.',
            'contact_phone' => '+0987654321',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/posts/{$post->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Post updated successfully'
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'description' => 'Updated post description.',
            'contact_phone' => '+0987654321',
        ]);
    }

    public function test_user_cannot_update_other_user_post()
    {
        $otherUser = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $updateData = [
            'title' => 'Updated Post Title',
            'description' => 'Updated post description.',
            'contact_phone' => '+0987654321',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/posts/{$post->id}", $updateData);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized to update this post'
            ]);
    }

    public function test_user_can_delete_own_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);

        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_user_cannot_delete_other_user_post()
    {
        $otherUser = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized to delete this post'
            ]);
    }

    public function test_user_can_view_own_posts()
    {
        Post::factory(3)->create([
            'user_id' => $this->user->id,
        ]);

        Post::factory(2)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/posts/my');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'contact_phone',
                            'user_id',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]);

        $this->assertEquals(3, count($response->json('data.data')));
    }
}
