<?php

use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\DishController;
use Illuminate\Support\Facades\Route;

Route::get('dishes', [DishController::class, 'index']);
Route::get('comments', [CommentsController::class, 'index']);
Route::post('comments', [CommentsController::class, 'store']);
