<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/', function () { return view('admin.index'); })->name('admin.dashboard');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/posts', [App\Http\Controllers\AdminController::class, 'posts'])->name('admin.posts');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::delete('/posts/{id}', [App\Http\Controllers\AdminController::class, 'deletePost'])->name('admin.posts.delete');
    // Users CRUD
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    // Posts CRUD
    Route::get('/posts/create', [App\Http\Controllers\AdminController::class, 'createPost'])->name('admin.posts.create');
    Route::post('/posts', [App\Http\Controllers\AdminController::class, 'storePost'])->name('admin.posts.store');
    Route::get('/posts/{id}/edit', [App\Http\Controllers\AdminController::class, 'editPost'])->name('admin.posts.edit');
    Route::put('/posts/{id}', [App\Http\Controllers\AdminController::class, 'updatePost'])->name('admin.posts.update');
});
