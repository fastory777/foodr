<?php

namespace App\Http\Controllers;

use App\Http\Resources\DishResource;
use App\Models\Dish;

class DishController extends Controller
{
    public function index()
    {
        return view('dishes');
    }

    public function show(Dish $dish) {
        $dishes = Dish::with('ingredients')->get();
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
