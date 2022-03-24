<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cep' => $this->faker->postcode(),
            'logradouro' => $this->faker->streetAddress(),
            'bairro' => $this->faker->lexify(),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->regionAbbr(),
            'cidadao_id' => $this->factoryForModel(App\User::class)->create()->id
        ];
    }
}
