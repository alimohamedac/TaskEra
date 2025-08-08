<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findByMobile(string $mobile): ?User;
    public function findByEmail(string $email): ?User;
    public function findByUsername(string $username): ?User;
    public function findById(int $id): ?User;
    public function getAllPaginated(int $perPage = 15);
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function getStats(): array;
} 