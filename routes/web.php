<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\CheckAccessTime;
use App\Models\Category;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('posts', AdminPostController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
    });

// Lọc bài viết theo category


Route::prefix('posts')
    ->controller(PostController::class)
    ->name('posts.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/category/{id}', 'byCategory')->name('byCategory');
        // Lọc bài viết theo tag
        Route::get('/tag/{id}',  'byTag')->name('byTag');
        Route::get('/{post}', 'show')->name('show');
    });
