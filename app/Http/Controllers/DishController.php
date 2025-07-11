<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\PreparationStep;
use Illuminate\Support\Facades\Log;
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
        $ingredients = Ingredient::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Dishes/Create', [
            'ingredients' => $ingredients,
        ]);
    }

    public function store(DishRequest $request)
    {
        $data = $request->all();

        // 1. Persist an image file to disk
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dishes', 'public');
            $data['image'] = $path;
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
                'duration_minutes' => $step['duration_minutes'] ?? null,
                'image_path' => $request->file("preparation_steps.$index.image") ? $request->file("preparation_steps.$index.image")->store('steps', 'public') : null,
            ]);
            // 5. Persist each preparation step's image to disk and store the path in $preparationStep
            if ($request->hasFile("preparation_steps.$index.image")) {
                $path = $request->file("preparation_steps.$index.image")->store('steps', 'public');
                $preparationStep->image_path = $path;
            }

            $preparationStep->save();

        }

        // * remember validation
        return redirect()->route('dishes.index')->with('message', 'Dish created successfully.');
    }

    public function edit(Dish $dish)
    {
        $dish->load([
            'ingredients' => fn ($q) => $q->withPivot(['amount', 'unit']),
            'preparationSteps',
        ]);

        \Log::info('Loaded steps:', $dish->preparationSteps->toArray());

        // Pass dish data and all linked ingredients to the Vue component
        return Inertia::render('Dishes/Edit', [
            'dish' => new DishResource($dish),
            'ingredients' => Ingredient::all(),
        ]);
    }

    public function update(Dish $dish, DishRequest $request)
    {

        // Validate data
        $data = $request->validated();
        // Update basic dish fields
        $dish->update($data);
        // reformat ingredients from the form into the pivot table
        $ingredientData = collect($data['ingredients'] ?? [])
            ->mapWithKeys(fn ($i) => [
                $i['id'] => [
                    'amount' => $i['amount'],
                    'unit' => $i['unit'],
                ]]);

        // Log::info('Ingredient data:', $ingredientData->all());

        // Sync ingredients in pivot table with the new values from the form
        $dish->ingredients()->sync($ingredientData);

        // Delete all old preparation steps before creating new ones
        $dish->preparationSteps()->delete();

        // Create each preparation step again from submitted data
        foreach ($data['preparation_steps'] as $step) {
            $dish->preparationSteps()->create($step);
        }

        return redirect()->route('dishes.index')->with('message', 'Dish updated successfully.');
    }
}
