<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Events\NewPostCreated;

class AdminController extends Controller
{
    protected $postService;
    protected $authService;

    public function __construct(PostService $postService, AuthService $authService)
    {
        $this->postService = $postService;
        $this->authService = $authService;
    }

    /**
     * Get all users (paginated)
     */
    public function users(Request $request): JsonResponse
    {
        $users = User::with(['posts'])->paginate(15);

        return response()->json(['success' => true, 'data' => $users]);
    }

    /**
     * Get all posts (paginated)
     */
    public function posts(Request $request): JsonResponse
    {
        $posts = Post::with(['user'])->orderBy('created_at', 'desc')->paginate(15);

        return response()->json(['success' => true, 'data' => $posts]);
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a post
     */
    public function deletePost(int $id): JsonResponse
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            $post->delete();

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

    // Users CRUD
    public function createUser() {
        return view('admin.users_create');
    }
    
    public function storeUser(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function editUser($id) {
        $user = User::findOrFail($id);

        return view('admin.users_edit', compact('user'));
    }
    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'mobile' => 'required|unique:users,mobile,'.$user->id,
            'password' => 'nullable|min:6',
        ]);

        if($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // Posts CRUD
    public function createPost() {
        $users = User::all();

        return view('admin.posts_create', compact('users'));
    }

    public function storePost(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|max:2048',
            'contact_phone' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        $post = Post::create($validated);

        event(new NewPostCreated($post));

        return redirect()->route('admin.posts')->with('success', 'تم إضافة المنشور بنجاح');
    }

    public function editPost($id) {
        $post = Post::findOrFail($id);
        $users = User::all();

        return view('admin.posts_edit', compact('post', 'users'));
    }

    public function updatePost(Request $request, $id) {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|max:2048',
            'contact_phone' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        $post->update($validated);

        return redirect()->route('admin.posts')->with('success', 'تم تحديث المنشور بنجاح');
    }
}
