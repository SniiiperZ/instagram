<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');


Route::post('/posts/destroy', [PostController::class, 'destroy'])->name('posts.destroy');

Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/users/{user}/follow', [ProfileController::class, 'follow'])->name('users.follow');
Route::post('/users/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('users.unfollow');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

require __DIR__.'/auth.php';
