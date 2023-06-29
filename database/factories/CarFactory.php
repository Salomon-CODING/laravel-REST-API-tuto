<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $carModels = ['Ford', 'Toyota', 'Honda', 'BMW', 'Mercedes'];
        $randomModel = array_rand($carModels);
        
        return [
            'model' => $carModels[$randomModel],
            'price' => fake()->numberBetween(10000, 50000),
            'description' => fake()->sentence(5),
            'image_path' => fake()->imageUrl(),
            'user_id' => fake()->numberBetween(1, 5),
        ];
    }
}

//Pour les fakers, chat GPT a des fakers pour tout. Que ce soit des adresses, code postal, numero de telephone et tout...