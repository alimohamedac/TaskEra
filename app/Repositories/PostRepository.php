<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function findById(int $id): ?Post
    {
        return Post::with('user')->find($id);
    }

    public function getAllPaginated(int $perPage = 15)
    {
        return Post::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByUser(int $userId, int $perPage = 15)
    {
        return Post::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function getRecentPosts(int $perPage = 15)
    {
        return Post::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
} 