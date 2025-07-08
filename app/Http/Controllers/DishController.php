<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\PreparationStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function create()
    {
        return Inertia::render('Dishes/Create');
    }

    public function store(DishRequest $request)
    {
        $data = $request->all();
        // 1. Persist an image file to disk
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dishes', 'public');
            $data['image'] = 'storage/' . $path;
        }

        // 2. Use persisted image's path and insert into $dish
        $dish = Dish::create($data);  // $dish = Dish::create($request->all());

        // 3. Iterate over ingredients and attach each $ingredient to $dish*
        foreach ($data['ingredients'] as $ingredient) {
            \Log::info('Ingredients:', $data['ingredients']);
            $dish->ingredients()->attach($ingredient['id'], [
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
            ]);
        }

        // 4. Iterate over preparation steps within the $request and create a new step for each entry*
        foreach ($data['preparation_steps'] as $index => $step) {
            $preparationStep = new PreparationStep([
                'dish_id' => $dish->id,
                'instruction' => $step['instruction'],
            ]);
            // 5. Persist each preparation step's image to disk and store the path in $preparationStep
            if ($request->hasFile("preparation_steps.$index.image")) {
                $path = $request->file("preparation_steps.$index.image")->store('steps', 'public');
                $preparationStep->image_path = 'storage/' . $path;
            }

            $preparationStep->save();

        }
        // * remember validation
        return redirect()->route('dishes.index')->with('message', 'Dish created successfully.');
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
