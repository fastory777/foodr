<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get meal IDs for reference
        $meals = DB::table('meals')->pluck('id', 'name')->toArray();

        // Insert dishes with meal_id
        $dishes = [
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Classic Italian pasta dish with a rich meat sauce.',
                'image' => 'dishes/spaghetti_bolognese.jpg',
                'meal_id' => $meals['Monday Dinner'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chicken Stir Fry',
                'description' => 'Quick and healthy stir-fried chicken with vegetables.',
                'image' => 'dishes/chicken_stir_fry.jpg',
                'meal_id' => $meals['Tuesday Lunch'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beef Tacos',
                'description' => 'Delicious Mexican tacos with seasoned ground beef.',
                'meal_id' => $meals['Wednesday Dinner'],
                'image' => 'dishes/chicken_stir_fry.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vegetable Curry',
                'description' => 'Flavorful curry with mixed vegetables and aromatic spices.',
                'meal_id' => $meals['Thursday Dinner'],
                'image' => 'dishes/chicken_stir_fry.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pancakes',
                'description' => 'Fluffy breakfast pancakes served with maple syrup.',
                'meal_id' => $meals['Saturday Breakfast'],
                'image' => 'dishes/chicken_stir_fry.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lasagna',
                'description' => 'Layered pasta dish with meat sauce and cheese.',
                'meal_id' => $meals['Sunday Dinner'],
                'image' => 'dishes/chicken_stir_fry.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('dishes')->insert($dishes);

        // Get ingredient IDs for reference
        $ingredients = DB::table('ingredients')->pluck('id', 'name')->toArray();

        // Define dish-ingredient relationships
        $dishIngredientRelations = [
            'Spaghetti Bolognese' => ['Pasta', 'Tomato', 'Beef', 'Garlic', 'Onion', 'Olive Oil', 'Salt', 'Pepper'],
            'Chicken Stir Fry' => ['Chicken', 'Garlic', 'Onion', 'Olive Oil', 'Salt', 'Pepper'],
            'Beef Tacos' => ['Beef', 'Tomato', 'Onion', 'Garlic', 'Flour', 'Salt', 'Pepper'],
            'Vegetable Curry' => ['Tomato', 'Onion', 'Garlic', 'Rice', 'Olive Oil', 'Salt', 'Pepper'],
            'Pancakes' => ['Flour', 'Eggs', 'Milk', 'Butter', 'Sugar'],
            'Lasagna' => ['Pasta', 'Tomato', 'Beef', 'Garlic', 'Onion', 'Olive Oil', 'Salt', 'Pepper', 'Milk'],
        ];

        // Insert dish-ingredient relationships
        $dishIngredientData = [];
        foreach ($dishIngredientRelations as $dishName => $ingredientNames) {
            $dishId = DB::table('dishes')->where('name', $dishName)->value('id');

            foreach ($ingredientNames as $ingredientName) {
                if (isset($ingredients[$ingredientName])) {
                    $dishIngredientData[] = [
                        'dish_id' => $dishId,
                        'ingredient_id' => $ingredients[$ingredientName],
                    ];
                }
            }
        }

        DB::table('dish_ingredient')->insert($dishIngredientData);
    }
}
