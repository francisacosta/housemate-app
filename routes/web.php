<?php

use App\Http\Controllers\PublicListingController;
use App\Http\Controllers\PublicRoommatePostController;
use App\Http\Controllers\RoommatePostController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('listings', [PublicListingController::class, 'index'])->name('listings.browse');
Route::get('listings/{listing}', [PublicListingController::class, 'show'])
    ->whereNumber('listing')
    ->name('listings.show');

Route::get('posts', [PublicRoommatePostController::class, 'index'])->name('posts.browse');
Route::get('posts/{roommatePost}', [PublicRoommatePostController::class, 'show'])
    ->whereNumber('roommatePost')
    ->name('posts.show');

Route::middleware(['auth'])->group(function () {
    Route::get('my-posts', [RoommatePostController::class, 'index'])->name('roommate-posts.index');
    Route::get('my-posts/create', [RoommatePostController::class, 'create'])->name('roommate-posts.create');
    Route::post('my-posts', [RoommatePostController::class, 'store'])->name('roommate-posts.store');
    Route::get('my-posts/{roommatePost}/edit', [RoommatePostController::class, 'edit'])
        ->whereNumber('roommatePost')
        ->name('roommate-posts.edit');
    Route::patch('my-posts/{roommatePost}', [RoommatePostController::class, 'update'])
        ->whereNumber('roommatePost')
        ->name('roommate-posts.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
