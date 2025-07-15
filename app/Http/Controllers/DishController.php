<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\PreparationStep;
use Illuminate\Support\Facades\Storage;
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
            'dish' => new DishResource($dish)->resolve(),
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
            'image' => 'storage/'.$request->file('image')->store('dishes', 'public'),
        ]); // manually store the image and override the 'image' field in the request
        $imagePath = 'storage/'.$request->file('image')->store('dishes', 'public'); // used below for clarity

        $dish = Dish::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'tips' => $request->input('tips'),
        ]);  // avoid using $request->all() to prevent storing temporary file objects

        // Attach each $ingredient to $dish
        foreach ($request->ingredients as $ingredient) {
            $dish->ingredients()->attach($ingredient['id'], [
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
            ]);
        }

        $data = $request->all();

        // 4. Iterate over preparation steps within the $request and create a new step for each entry*

        $this->createPreparationSteps($request->preparation_steps, $dish, $request);

        return redirect()
            ->route('dishes.index')
            ->with('message', 'Dish created successfully.');
    }

    public function edit(Dish $dish)
    {
        $dish->load(
            'ingredients',
            'preparationSteps',
        );

        // Pass dish data and all linked ingredients to the Vue component
        return Inertia::render('Dishes/Edit', [
            'dish' => new DishResource($dish),
            'ingredients' => Ingredient::all(),
        ]);
    }

    public function update(Dish $dish, DishRequest $request)
    {
        $imagePath = $dish->image; // default to current image path

        if ($request->hasFile('image')) {
            $imagePath = 'storage/'.$request->file('image')->store('dishes', 'public'); // Store new image if uploaded
        }

        // Update basic dish fields
        $dish->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'tips' => $request->input('tips'),
        ]); // Clear list the fields to prevent Laravel from accidentally saving Laravel file objects

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
        $this->createPreparationSteps($request->preparation_steps, $dish, $request);

        return redirect()->route('dishes.index')->with('message', 'Dish updated successfully.');
    }

    private function createPreparationSteps(array $steps, Dish $dish, $request): void
    {
        foreach ($steps as $index => $step) {
            $imagePath = null;

            if ($request->hasFile("preparation_steps.$index.image")) {
                $imagePath = $request->file("preparation_steps.$index.image")->store('steps', 'public');
            } // manually store each step image and get the path

            $preparationStep = new PreparationStep([
                'dish_id' => $dish->id,
                'instruction' => $step['instruction'],
                'duration_minutes' => $step['duration_minutes'] ?? null,
            ]);

            if ($imagePath) {
                $preparationStep->image = $imagePath; // only set image if uploaded
            }

            logger('Saved step', ['image' => $imagePath]);

            $preparationStep->save();
        }
    }

    public function destroy(Dish $dish)
    {
        // delete the main image
        Storage::disk('public')->delete(str_replace('storage/', '', $dish->image));

        // delete the images from the preparation steps
        foreach ($dish->preparationSteps as $step) {
            if ($step->image) {
                Storage::disk('public')->delete($step->image);
            }
        }

        $dish->preparationSteps()->delete();
        $dish->ingredients()->detach();
        $dish->delete();

        return redirect()->route('dishes.index')->with('message', 'Dish deleted successfully.');
    }
}
