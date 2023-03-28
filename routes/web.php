<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//subscriber
Route::post('subscriber', [App\Http\Controllers\SubscriberController::class,'subscriber'])->name('user.subscribe');
//post details
Route::get('post/{slug}', [App\Http\Controllers\PostController::class,'post_details'])->name('post.details');
//All Post
Route::get('posts',[App\Http\Controllers\PostController::class,'All_post'])->name('all.post');
//category Post
Route::get('category/{slug}',[App\Http\Controllers\PostController::class,'category_post'])->name('category.post');
//tag Post
Route::get('tag/{slug}',[App\Http\Controllers\PostController::class,'tag_post'])->name('tag.post');
//search
Route::get('search',[App\Http\Controllers\SearchController::class,'search'])->name('search');
//Author post
Route::get('profile/{username}',[App\Http\Controllers\AuthorPostController::class,'author_post'])->name('post.author');

Route::group(['middleware' => 'auth'], function (){
    //Favorite Post
    Route::post('favourite-post/{id}', [App\Http\Controllers\FavouritePostControler::class, 'favorite'])->name('favorite.post');
    //comment
    Route::post('comment/{id}', [App\Http\Controllers\CommentController::class, 'comment'])->name('comment');

});

Auth::routes();

Route::group(['as'=> 'admin.','prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function (){
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    //Tag route
    Route::get('tag', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('tag');
    Route::get('tag/create', [App\Http\Controllers\Admin\TagController::class, 'create'])->name('tag.create');
    Route::post('tag/store', [App\Http\Controllers\Admin\TagController::class, 'store'])->name('tag.store');
    Route::get('tag/edit/{id}', [App\Http\Controllers\Admin\TagController::class, 'edit'])->name('tag.edit');
    Route::put('tag/update/{id}', [App\Http\Controllers\Admin\TagController::class, 'update'])->name('tag.update');
    Route::delete('tag/destroy/{id}', [App\Http\Controllers\Admin\TagController::class, 'destroy'])->name('tag.destroy');
    //Category route
    Route::get('category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category');
    Route::get('category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/destroy/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.destroy');
    //Post route
    Route::get('post', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('post');
    Route::get('post/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('post.create');
    Route::post('post/store', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('post.store');
    Route::get('post/edit/{id}', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('post.edit');
    Route::put('post/update/{id}', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('post.update');
    Route::delete('post/destroy/{id}', [App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/show/{id}', [App\Http\Controllers\Admin\PostController::class, 'show'])->name('post.show');

    //pending Post route
    Route::get('pending/post', [App\Http\Controllers\Admin\PostController::class, 'pending'])->name('post.pending');
    Route::put('post/approve/{id}', [App\Http\Controllers\Admin\PostController::class, 'approve'])->name('post.approve');

    //subscriber route
    Route::get('subscribers', [App\Http\Controllers\Admin\SubscriberController::class, 'subscriber'])->name('subscriber');
    Route::delete('subscribers/destroy/{id}', [App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('subscriber.destroy');

    //settings route
    Route::get('profile/settings', [App\Http\Controllers\Admin\SettingsController::class, 'profile'])->name('profile.settings');
    Route::put('profile/update', [App\Http\Controllers\Admin\SettingsController::class, 'profileUpdate'])->name('profile.update');

    //change password
    Route::put('change-password',[App\Http\Controllers\Admin\SettingsController::class, 'UpdatePassword'])->name('change.password');

    //favorite password
    Route::get('favourite-post', [App\Http\Controllers\Admin\FavouritePostControler::class, 'favorite'])->name('favorite.post');
    Route::delete('favourite-post/destroy/{id}', [App\Http\Controllers\Admin\FavouritePostControler::class, 'destroy'])->name('favorite-post.destroy');

    //comment
    Route::get('comment', [App\Http\Controllers\Admin\CommentController::class, 'comment'])->name('comment');
    Route::delete('comment/destroy/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comment.destroy');

});

Route::group(['as'=> 'author.','prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function (){
    Route::get('/dashboard', [App\Http\Controllers\Author\DashboardController::class,'index'])->name('dashboard');

    //Post route
    Route::get('post', [App\Http\Controllers\Author\PostController::class, 'index'])->name('post');
    Route::get('post/create', [App\Http\Controllers\Author\PostController::class, 'create'])->name('post.create');
    Route::post('post/store', [App\Http\Controllers\Author\PostController::class, 'store'])->name('post.store');
    Route::get('post/edit/{id}', [App\Http\Controllers\Author\PostController::class, 'edit'])->name('post.edit');
    Route::put('post/update/{id}', [App\Http\Controllers\Author\PostController::class, 'update'])->name('post.update');
    Route::delete('post/destroy/{id}', [App\Http\Controllers\Author\PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/show/{id}', [App\Http\Controllers\Author\PostController::class, 'show'])->name('post.show');

    //settings route
    Route::get('profile/settings', [App\Http\Controllers\Author\SettingsController::class, 'profile'])->name('profile.settings');
    Route::put('profile/update', [App\Http\Controllers\Author\SettingsController::class, 'profileUpdate'])->name('profile.update');

    //change password
    Route::put('change-password',[App\Http\Controllers\Author\SettingsController::class, 'UpdatePassword'])->name('change.password');

    //favorite password
    Route::get('favourite-post', [App\Http\Controllers\Author\FavouritePostControler::class, 'favorite'])->name('favorite.post');
    Route::delete('favourite-post/destroy/{id}', [App\Http\Controllers\Author\FavouritePostControler::class, 'destroy'])->name('favorite-post.destroy');

    //comment
    Route::get('comment', [App\Http\Controllers\Author\CommentController::class, 'comment'])->name('comment');
    Route::delete('comment/destroy/{id}', [App\Http\Controllers\Author\CommentController::class, 'destroy'])->name('comment.destroy');


});

View::composer('layouts.frontend.partial.footer', function ($view){
    $categories = Category::all();
    $view->with('categories', $categories);

});
