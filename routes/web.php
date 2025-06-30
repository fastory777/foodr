<?php

use App\Http\Controllers\DishController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DishController::class, 'index']);
Route::get('dish/{dish}', [DishController::class, 'show']);

