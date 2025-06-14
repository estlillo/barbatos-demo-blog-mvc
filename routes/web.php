<?php

use App\Http\Controllers\AlfrescoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('casa', 'casa')
    ->middleware(['auth', 'verified'])
    ->name('casa');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

Route::resource('categories', CategoryController::class, )
    ->names('categories')
    ->middleware(['auth', 'verified', 'role:admin']);

Route::resource('posts', PostController::class)
    ->names('posts')
    ->middleware(['auth', 'verified', 'role:admin|user']);

Route::get('posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/download/{file}', [DownloadController::class, 'download'])
    ->name('file.download');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware(['auth'])
    ->name('comments.store');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::post('/alfresco/upload', [AlfrescoController::class, 'upload'])->name('alfresco.upload');

require __DIR__.'/auth.php';
