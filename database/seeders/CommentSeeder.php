<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $dishes = Dish::all();
        $users = User::all();

        if ($dishes->count() === 0) {
            $this->command->warn('No dishes found — skipping comment seeding.');

            return;
        }

        foreach (range(1, 20) as $i) {
            $dish = $dishes->random();
            $user = $users->random();

            Comment::create([
                'dish_id' => rand(1, 10) <= 2 ? null : $dish->id,
                'user_id' => $user->id,
                'author_name' => $user->name,
                'content' => Str::random(rand(30, 100)),
            ]);
        }
    }
}
