<?php

use App\Http\Controllers\Api\DishController;
use Illuminate\Support\Facades\Route;

Route::get('dishes', [DishController::class, 'index']);
