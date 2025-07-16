<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call the seeders in the correct order
        $this->call([
            IngredientSeeder::class,
            MealSeeder::class,
            DishSeeder::class,
            TodoListSeeder::class,
            TodoItemSeeder::class,
            PreparationStepSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
