<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Events\NewPostCreated;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of posts (public)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $posts = $this->postService->getPublicPosts($perPage);

            $posts->getCollection()->transform(function ($post) {
                $post->short_description = $post->short_description;
                return $post;
            });

            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created post
     */
    public function store(CreatePostRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $post = $this->postService->createPost($request->validated(), $user->id);

            event(new NewPostCreated($post));

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post->load('user')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified post
     */
    public function show(int $id): JsonResponse
    {
        try {
            $post = $this->postService->getPost($id);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified post
     */
    public function update(CreatePostRequest $request, int $id): JsonResponse
    {
        try {
            $post = $this->postService->getPost($id);
            $user = auth()->user();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            if ($post->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this post'
                ], 403);
            }

            $updatedPost = $this->postService->updatePost($post, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $updatedPost->load('user')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified post
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $post = $this->postService->getPost($id);
            $user = auth()->user();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            if ($post->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this post'
                ], 403);
            }

            $this->postService->deletePost($post);

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
