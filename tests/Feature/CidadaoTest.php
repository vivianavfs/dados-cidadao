<?php

namespace Tests\Feature;

use App\Models\Cidadao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CidadaoTest extends TestCase
{
    //Reseta o banco a cada teste
    use RefreshDatabase;

    public function test_getCidadaosStatus()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }

    public function test_getCidadaosJson()
    {
        $this->seed();

        $response = $this->get('/api');

        $response->assertJsonCount(10);
    }


    public function test_postCidadaoStatusSemDados()
    {
        $response = $this->post('/api/create');

        $response->assertStatus(422);
    }

    public function test_postCidadaoJson()
    {
        $cidadao = new Cidadao();
        $cidadao->nome = "João";
        $cidadao->sobrenome = 'Silva';
        $cidadao->cpf = '11111111111';
        $cidadao->cep = '01101-000';
        $cidadao->email = 'a@a.com';
        $cidadao->celular = '11999989796';

        $response = $this->postJson('/api/create', $cidadao->toArray());

        $response->assertJsonFragment($cidadao->toArray());
    }

    public function test_putEditCidadaoJson()
    {
        $this->seed();

        $cidadao = Cidadao::with('contato', 'endereco')->first();

        $response = $this->putJson('/api/edit/' . $cidadao->id, ['nome' => 'Maria']);

        $response->assertJsonFragment(['nome' => 'Maria']);
    }

    public function test_deleteCidadao()
    {
        $this->seed();

        $cidadao = Cidadao::first();

        $response = $this->delete('/api/delete/' . $cidadao->id);

        $response->assertStatus(200);

        $this->assertDeleted('cidadaos', $cidadao->toArray());

    }
}
