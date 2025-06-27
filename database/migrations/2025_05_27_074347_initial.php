<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->foreignId('meal_id')->constrained();
        });

        Schema::create('dish_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dish_id')->constrained();
            $table->foreignId('ingredient_id')->constrained();
        });

        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->foreignId('todo_list_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todo_items');
        Schema::dropIfExists('todo_lists');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('meals');
        Schema::dropIfExists('dish_ingredient');
    }
};
