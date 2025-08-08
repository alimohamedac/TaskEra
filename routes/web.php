<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web'])
    ->group(function () {

        Route::get('/', function () {
            return view('admin.index');
        })->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/posts/create', [AdminController::class, 'createPost'])->name('posts.create');
        Route::post('/posts', [AdminController::class, 'storePost'])->name('posts.store');
        Route::get('/posts/{id}/edit', [AdminController::class, 'editPost'])->name('posts.edit');
        Route::put('/posts/{id}', [AdminController::class, 'updatePost'])->name('posts.update');
        Route::delete('/posts/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');
    });
