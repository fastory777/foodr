<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TodoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get todo list IDs for reference
        $todoLists = DB::table('todo_lists')->pluck('id', 'name')->toArray();

        // Create todo items for each list
        $todoItems = [
            // Grocery Shopping items
            [
                'name' => 'Buy vegetables',
                'completed_at' => Carbon::now()->subDays(1),
                'todo_list_id' => $todoLists['Grocery Shopping'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Get pasta and rice',
                'completed_at' => Carbon::now()->subDays(1),
                'todo_list_id' => $todoLists['Grocery Shopping'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buy chicken and beef',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Grocery Shopping'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Get spices and herbs',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Grocery Shopping'],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Weekly Meal Prep items
            [
                'name' => 'Prepare lunch containers',
                'completed_at' => Carbon::now()->subDays(2),
                'todo_list_id' => $todoLists['Weekly Meal Prep'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cook rice for the week',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Weekly Meal Prep'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prepare vegetable portions',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Weekly Meal Prep'],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kitchen Cleaning items
            [
                'name' => 'Clean refrigerator',
                'completed_at' => Carbon::now()->subDays(5),
                'todo_list_id' => $todoLists['Kitchen Cleaning'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wash dishes',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Kitchen Cleaning'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organize pantry',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Kitchen Cleaning'],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Recipe Ideas items
            [
                'name' => 'Find new pasta recipes',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Recipe Ideas'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Research vegetarian options',
                'completed_at' => null,
                'todo_list_id' => $todoLists['Recipe Ideas'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Look up quick breakfast ideas',
                'completed_at' => Carbon::now()->subDays(3),
                'todo_list_id' => $todoLists['Recipe Ideas'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('todo_items')->insert($todoItems);
    }
}
