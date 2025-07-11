<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\PreparationStep;
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
        // Persist an image file to disk
        $request->merge([
            'image' => $request->file('image')->store('dishes', 'public'),
        ]);

        $dish = Dish::create($request->all());

        // Attach each $ingredient to $dish
        foreach ($request->ingredients as $ingredient) {
            $dish->ingredients()->attach($ingredient['id'], [
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
            ]);
        }

        $data = $request->all();

        // 4. Iterate over preparation steps within the $request and create a new step for each entry*
        foreach ($request->preparation_steps as $index => $step) {
            $preparationStep = new PreparationStep::([
                'instruction' => $step['instruction'],
                'duration_minutes' => $step['duration_minutes'] ?? null,
                'image' => $request->file("preparation_steps.$index.image")->store('steps', 'public'),
            ]);

            // 5. Persist each preparation step's image to disk and store the path in $preparationStep
            if ($request->hasFile("preparation_steps.$index.image")) {
                $path = $request->file("preparation_steps.$index.image")->store('steps', 'public');
                $preparationStep->image_path = $path;
            }

            $preparationStep->save();

        }

        return redirect()
            ->route('dishes.index')
            ->with('message', 'Dish created successfully.');
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
        // Update basic dish fields
        $dish->update($request->all());

        $data = $request->validated();

        // reformat ingredients from the form into the pivot table
        $ingredientData = collect($data['ingredients'] ?? [])
            ->mapWithKeys(fn ($i) => [
                $i['id'] => [
                    'amount' => $i['amount'],
                    'unit' => $i['unit'],
                ]]);

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
