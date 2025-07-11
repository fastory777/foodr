<?php

use App\Http\Controllers\DishController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DishController::class, 'index'])->name('dishes.index');
Route::get('dish/create', [DishController::class, 'create'])->name('dishes.create');
Route::get('dish/{dish}', [DishController::class, 'show'])->name('dishes.show');
Route::post('dish', [DishController::class, 'store'])->name('dishes.store');
Route::get('dish/{dish}/edit', [DishController::class, 'edit'])->name('dishes.edit');
Route::match(['put', 'post'], 'dish/{dish}', [DishController::class, 'update'])->name('dishes.update'); // The only valid values for the method attribute are get and post, corresponding to the GET and POST HTTP methods.
