<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreparationStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all dishes using Eloquent
        $dishes = Dish::all();

        $preparationSteps = [];

        foreach ($dishes as $dish) {
            // Skip if dish already has preparation steps
            if ($dish->preparationSteps()->exists()) continue;

                // Generate 3-5 preparation steps for each dish
                $numSteps = rand(3, 5);

            // Create steps based on dish name
            $steps = $this->generateStepsForDish($dish->name, $numSteps);

            // Add steps to the array
            for ($i = 0; $i < count($steps); $i++) {
                $preparationSteps[] = [
                    'dish_id' => $dish->id,
                    'instruction' => $steps[$i]['instruction'],
                    'duration_minutes' => $steps[$i]['duration_minutes'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all preparation steps
        DB::table('preparation_steps')->insert($preparationSteps);
    }

    /**
     * Generate preparation steps based on dish name.
     *
     * @param string $dishName
     * @param int $numSteps
     * @return array
     */
    private function generateStepsForDish(string $dishName, int $numSteps): array
    {
        $steps = [];

        // Determine dish type based on name
        $dishType = $this->determineDishType($dishName);

        // Generate steps based on dish type
        switch ($dishType) {
            case 'pasta':
                $steps = $this->generatePastaSteps($numSteps);
                break;
            case 'stir_fry':
                $steps = $this->generateStirFrySteps($numSteps);
                break;
            case 'tacos':
                $steps = $this->generateTacoSteps($numSteps);
                break;
            case 'curry':
                $steps = $this->generateCurrySteps($numSteps);
                break;
            case 'pancakes':
                $steps = $this->generatePancakeSteps($numSteps);
                break;
            case 'lasagna':
                $steps = $this->generateLasagnaSteps($numSteps);
                break;
            default:
                $steps = $this->generateGenericSteps($numSteps);
                break;
        }

        return $steps;
    }

    /**
     * Determine dish type based on name.
     *
     * @param string $dishName
     * @return string
     */
    private function determineDishType(string $dishName): string
    {
        $dishName = strtolower($dishName);

        if (str_contains($dishName, 'pasta') || str_contains($dishName, 'spaghetti')) {
            return 'pasta';
        } elseif (str_contains($dishName, 'stir fry')) {
            return 'stir_fry';
        } elseif (str_contains($dishName, 'taco')) {
            return 'tacos';
        } elseif (str_contains($dishName, 'curry')) {
            return 'curry';
        } elseif (str_contains($dishName, 'pancake')) {
            return 'pancakes';
        } elseif (str_contains($dishName, 'lasagna')) {
            return 'lasagna';
        } else {
            return 'generic';
        }
    }

    /**
     * Generate pasta preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generatePastaSteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Bring a large pot of salted water to a rolling boil. Add a tablespoon of salt to the water.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Heat olive oil in a large pan over medium heat. Add finely chopped onions and garlic, sauté until translucent.',
                'duration_minutes' => 7,
            ],
            [
                'instruction' => 'Add ground beef to the pan and cook until browned, breaking it apart with a wooden spoon.',
                'duration_minutes' => 8,
            ],
            [
                'instruction' => 'Pour in crushed tomatoes and tomato paste. Add Italian herbs, salt, and pepper. Simmer on low heat.',
                'duration_minutes' => 15,
            ],
            [
                'instruction' => 'Cook pasta in the boiling water according to package instructions until al dente.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Drain the pasta, reserving a cup of pasta water. Add pasta to the sauce and toss to combine.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Serve hot with freshly grated Parmesan cheese and chopped fresh basil on top.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate stir fry preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generateStirFrySteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Slice chicken breast into thin strips and marinate with soy sauce, garlic, and a pinch of sugar.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Prepare all vegetables by washing and cutting them into uniform, bite-sized pieces.',
                'duration_minutes' => 8,
            ],
            [
                'instruction' => 'Heat a wok or large frying pan over high heat. Add vegetable oil and swirl to coat.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add chicken to the hot wok and stir-fry until golden and cooked through. Remove and set aside.',
                'duration_minutes' => 6,
            ],
            [
                'instruction' => 'In the same wok, add a bit more oil if needed, then add harder vegetables like carrots and broccoli first.',
                'duration_minutes' => 4,
            ],
            [
                'instruction' => 'Add softer vegetables like bell peppers and snow peas. Stir-fry for a few minutes until crisp-tender.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Return chicken to the wok, add stir-fry sauce, and toss everything together until well combined and heated through.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Serve immediately over steamed rice, garnished with sliced green onions.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate taco preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generateTacoSteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Heat a large skillet over medium-high heat. Add a tablespoon of oil.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add ground beef to the skillet, breaking it apart with a wooden spoon as it cooks.',
                'duration_minutes' => 7,
            ],
            [
                'instruction' => 'Once beef is browned, add taco seasoning and water according to seasoning instructions. Simmer until thickened.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'While the meat cooks, dice tomatoes, shred lettuce, and prepare other desired toppings.',
                'duration_minutes' => 8,
            ],
            [
                'instruction' => 'Warm taco shells in the oven at 350°F (175°C) for about 5 minutes or according to package directions.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Assemble tacos by placing a spoonful of beef in each shell, then adding toppings as desired.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Serve immediately with lime wedges, hot sauce, and sour cream on the side.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate curry preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generateCurrySteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Heat oil in a large pot over medium heat. Add cumin seeds and let them sizzle for 30 seconds.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add finely chopped onions and sauté until golden brown, about 5-7 minutes.',
                'duration_minutes' => 7,
            ],
            [
                'instruction' => 'Add minced garlic, ginger, and green chilies. Sauté for another 2 minutes until fragrant.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add curry powder, turmeric, coriander, and cumin. Stir continuously for 1 minute to toast the spices.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add diced vegetables (potatoes, carrots, cauliflower, etc.) and stir to coat with the spices.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Pour in coconut milk and vegetable broth. Bring to a simmer, then reduce heat to low.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Cover and cook for 15-20 minutes, or until vegetables are tender but not mushy.',
                'duration_minutes' => 15,
            ],
            [
                'instruction' => 'Stir in fresh spinach or peas in the last 5 minutes of cooking if desired.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Serve hot over steamed rice, garnished with fresh cilantro and a squeeze of lime juice.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate pancake preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generatePancakeSteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'In a large bowl, whisk together flour, sugar, baking powder, and salt.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'In another bowl, whisk together milk, eggs, and melted butter until well combined.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Pour the wet ingredients into the dry ingredients and stir just until combined. Some lumps are okay.',
                'duration_minutes' => 2,
            ],
            [
                'instruction' => 'Let the batter rest for 5-10 minutes to allow the gluten to relax and the baking powder to activate.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Heat a non-stick skillet or griddle over medium heat. Add a small amount of butter or oil to coat.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Pour 1/4 cup of batter onto the skillet for each pancake. Cook until bubbles form on the surface.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Flip the pancakes and cook until golden brown on the other side, about 1-2 minutes more.',
                'duration_minutes' => 2,
            ],
            [
                'instruction' => 'Serve hot with maple syrup, fresh berries, or your favorite toppings.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate lasagna preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generateLasagnaSteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Preheat oven to 375°F (190°C). In a large pot, heat olive oil over medium heat.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Add onions and garlic to the pot and sauté until soft and translucent, about 5 minutes.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Add ground beef and cook until browned, breaking it apart with a wooden spoon.',
                'duration_minutes' => 8,
            ],
            [
                'instruction' => 'Stir in crushed tomatoes, tomato paste, Italian herbs, salt, and pepper. Simmer for 15-20 minutes.',
                'duration_minutes' => 15,
            ],
            [
                'instruction' => 'In a separate bowl, mix ricotta cheese, half the mozzarella, Parmesan, eggs, and chopped parsley.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'If using uncooked lasagna noodles, soak them in hot water for 10 minutes to soften slightly.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Spread a thin layer of meat sauce on the bottom of a 9x13 inch baking dish.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Layer lasagna noodles, meat sauce, and cheese mixture. Repeat layers, ending with sauce and remaining mozzarella on top.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Cover with foil and bake for 25 minutes. Remove foil and bake for another 15 minutes until bubbly and golden.',
                'duration_minutes' => 40,
            ],
            [
                'instruction' => 'Let stand for 10-15 minutes before cutting and serving to allow the layers to set.',
                'duration_minutes' => 15,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Generate generic preparation steps.
     *
     * @param int $numSteps
     * @return array
     */
    private function generateGenericSteps(int $numSteps): array
    {
        $allSteps = [
            [
                'instruction' => 'Prepare all ingredients by washing, peeling, and chopping as needed.',
                'duration_minutes' => 10,
            ],
            [
                'instruction' => 'Heat a large pan or pot over medium heat. Add oil or butter.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Add aromatics like onions, garlic, and herbs. Sauté until fragrant and softened.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Add main ingredients and cook according to recipe requirements.',
                'duration_minutes' => 12,
            ],
            [
                'instruction' => 'Add liquids if needed and bring to a simmer. Adjust heat as necessary.',
                'duration_minutes' => 5,
            ],
            [
                'instruction' => 'Cover and cook until all ingredients are properly cooked through.',
                'duration_minutes' => 15,
            ],
            [
                'instruction' => 'Season with salt, pepper, and any additional spices to taste.',
                'duration_minutes' => 3,
            ],
            [
                'instruction' => 'Serve hot with your favorite sides and garnishes.',
                'duration_minutes' => 5,
            ],
        ];

        return $this->selectRandomSteps($allSteps, $numSteps);
    }

    /**
     * Select random steps from all available steps.
     *
     * @param array $allSteps
     * @param int $numSteps
     * @return array
     */
    private function selectRandomSteps(array $allSteps, int $numSteps): array
    {
        // Ensure we don't try to select more steps than available
        $numSteps = min($numSteps, count($allSteps));

        // Always include the first step (preparation) and last step (serving)
        $selectedSteps = [];
        $selectedSteps[] = $allSteps[0];

        // Select random steps for the middle
        $middleSteps = array_slice($allSteps, 1, count($allSteps) - 2);
        $numMiddleSteps = $numSteps - 2; // Subtract first and last steps

        if ($numMiddleSteps > 0 && count($middleSteps) > 0) {
            // Shuffle the middle steps
            shuffle($middleSteps);

            // Take the required number of middle steps
            $selectedMiddleSteps = array_slice($middleSteps, 0, $numMiddleSteps);

            // Sort them to maintain logical cooking order
            usort($selectedMiddleSteps, function($a, $b) use ($middleSteps) {
                return array_search($a, $middleSteps) - array_search($b, $middleSteps);
            });

            // Add the middle steps to the selected steps
            foreach ($selectedMiddleSteps as $step) {
                $selectedSteps[] = $step;
            }
        }

        // Add the last step (serving)
        $selectedSteps[] = $allSteps[count($allSteps) - 1];

        return $selectedSteps;
    }
}
