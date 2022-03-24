<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CidadaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->firstName(),
            'sobrenome' => $this->faker->lastName(),
            'cpf' => $this->faker->unique()->cpf(false)
        ];
    }
}
