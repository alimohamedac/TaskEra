<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): array
    {
        $user = $this->userRepository->create($data);
        
        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
            'message' => 'User registered successfully'
        ];
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->findByMobile($data['mobile']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            throw new \Exception('Could not create token');
        }

        return [
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
        ];
    }

    public function logout(): array
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return ['message' => 'Successfully logged out'];
        } catch (JWTException $e) {
            throw new \Exception('Could not log out');
        }
    }

    public function me(): User
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
