<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create meals
        $meals = [
            [
                'name' => 'Monday Dinner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tuesday Lunch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wednesday Dinner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thursday Dinner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Saturday Breakfast',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sunday Dinner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('meals')->insert($meals);
    }
}
