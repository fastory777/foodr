<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DishResource;
use App\Models\Dish;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::with('ingredients')->get();

        return DishResource::collection($dishes);
    }
}
