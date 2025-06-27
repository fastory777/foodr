<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todoLists = [
            [
                'name' => 'Grocery Shopping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Weekly Meal Prep',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kitchen Cleaning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Recipe Ideas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('todo_lists')->insert($todoLists);
    }
}
