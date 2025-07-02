<?php

namespace App\Http\Controllers;

use App\Http\Resources\DishResource;
use App\Models\Dish;
use Inertia\Inertia;

class DishController extends Controller
{
    public function index()
    {
        return Inertia::render('Dishes/Index');
    }

    public function show(Dish $dish)
    {
        $dish->load('ingredients', 'preparationSteps');

        return Inertia::render('Dishes/Show', [
            'dish' => (new DishResource($dish))->resolve(),
        ]);
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
