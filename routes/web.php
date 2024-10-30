<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

// Routes accessibles publiquement
Route::get('/', function () {
    return view('welcome');
});

Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Routes nécessitant une authentification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
    
    // Création, modification et suppression de posts
    Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/share', [PostController::class, 'share'])->name('posts.share'); // Ajout de la route de partage ici
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Likes et commentaires
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Suivre / ne plus suivre un utilisateur
    Route::post('/users/{user}/follow', [ProfileController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('users.unfollow');

    // Messagerie
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/chat/{user}', [MessageController::class, 'showChat'])->name('messages.chat');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');

    // Stories
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
});

// Authentification
require __DIR__.'/auth.php';
