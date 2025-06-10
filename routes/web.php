<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    ->middleware(['auth', 'verified', 'role:admin']);

Route::get('/download/{file}', [DownloadController::class, 'download'])
    ->middleware('auth')
    ->name('file.download');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
