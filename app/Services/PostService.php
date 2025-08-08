<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class PostService
{
    protected $postRepository;
    protected $userRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function createPost(array $data, int $userId): Post
    {
        $data['user_id'] = $userId;
        return $this->postRepository->create($data);
    }

    public function getPosts(int $perPage = 15)
    {
        return $this->postRepository->getAllPaginated($perPage);
    }

    public function getPostsByUser(int $userId, int $perPage = 15)
    {
        return $this->postRepository->getByUser($userId, $perPage);
    }

    public function getPost(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

    public function updatePost(Post $post, array $data): Post
    {
        return $this->postRepository->update($post, $data);
    }

    public function deletePost(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }

    public function getPublicPosts(int $perPage = 15)
    {
        return $this->postRepository->getRecentPosts($perPage);
    }

    public function getStats(): array
    {
        return $this->postRepository->getStats();
    }
} 