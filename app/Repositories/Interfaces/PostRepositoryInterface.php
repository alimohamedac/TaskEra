<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function create(array $data): Post;
    public function findById(int $id): ?Post;
    public function getAllPaginated(int $perPage = 15);
    public function getByUser(int $userId, int $perPage = 15);
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
    public function getRecentPosts(int $perPage = 15);
} 