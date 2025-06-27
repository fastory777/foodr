<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Salt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pepper', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Olive Oil', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Garlic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Onion', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tomato', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chicken', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beef', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rice', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pasta', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Flour', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sugar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Butter', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Milk', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eggs', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('ingredients')->insert($ingredients);
    }
}
