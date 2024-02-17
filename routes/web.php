<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile.index');
    Route::put('/profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');

    Route::get('/password/change', 'App\Http\Controllers\PasswordController@showChangePasswordForm')->name('password.change');
    Route::post('/password/change', 'App\Http\Controllers\PasswordController@changePassword')->name('password.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-only', function () {
        return "This is a protected admin route.";
    });

    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@index')->name('admin.dashboard');

    Route::get('/admin/posts', 'App\Http\Controllers\PostController@index')->name('admin.posts.index');
    Route::get('/admin/posts/create', 'App\Http\Controllers\PostController@create')->name('admin.posts.create');
    Route::post('/admin/posts/store', 'App\Http\Controllers\PostController@store')->name('admin.posts.store');
    Route::get('/admin/posts/{post}/edit', 'App\Http\Controllers\PostController@edit')->name('admin.posts.edit');
    Route::put('/admin/posts/{post}', 'App\Http\Controllers\PostController@update')->name('admin.posts.update');
    Route::delete('/admin/posts/destroy', 'App\Http\Controllers\PostController@destroy')
        ->name('admin.posts.destroy');

    Route::get('/admin/categories', 'App\Http\Controllers\AdminController@categories')->name('admin.categories.index');
    Route::put('/admin/categories/{category}', 'App\Http\Controllers\AdminController@updateCategory')->name('admin.categories.update');
    Route::get('/admin/categories/{category}/edit', 'App\Http\Controllers\AdminController@editCategory')->name('admin.categories.edit');
    Route::post('/admin/categories', 'App\Http\Controllers\AdminController@storeCategory')->name('admin.categories.store');
    Route::delete('/admin/categories/{category}', 'App\Http\Controllers\AdminController@destroyCategory')->name('admin.categories.destroy');

    Route::get('/admin/users', 'App\Http\Controllers\AdminController@users')->name('admin.users.index');

    Route::get('/admin/users/{user}/edit', 'App\Http\Controllers\AdminController@editUser')->name('admin.users.edit');
    Route::put('/admin/users/{user}', 'App\Http\Controllers\AdminController@updateUser')->name('admin.users.update');
    Route::delete('/admin/users/{user}', 'App\Http\Controllers\AdminController@destroyUser')->name('admin.users.destroy');

    // Route::get('/admin/settings', 'App\Http\Controllers\AdminController@settings')->name('admin.settings.index');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [SettingsController::class, 'store'])->name('admin.settings.store');
});
