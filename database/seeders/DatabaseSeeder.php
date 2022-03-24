<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Cidadao::factory(10)->create()->each(function ($cidadao) {
            \App\Models\Contato::factory(1)->create(['cidadao_id' => $cidadao->id]);
            \App\Models\Endereco::factory(1)->create(['cidadao_id' => $cidadao->id]);
        });
    }
}
