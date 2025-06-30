<?php

namespace App\Http\Controllers;

use App\Http\Resources\DishResource;
use App\Models\Dish;

class DishController extends Controller
{
    public function index()
    {
        return view('dishes.index');
    }

    public function show(Dish $dish)
    {
        return view('dishes.show');
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
