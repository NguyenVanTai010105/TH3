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


Route::prefix('posts')
    ->controller(PostController::class)
    ->name('posts.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/{post}', 'show')->name('show');
    });
