<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'celular' => $this->faker->unique()->phoneNumberCleared(),
            'cidadao_id' => $this->factoryForModel(App\User::class)->create()->id,
        ];
    }
}
