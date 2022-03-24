<?php

namespace App\Http\Controllers;

use App\Models\Cidadao;
use App\Models\Contato;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class CidadaoController extends Controller
{
    public function getCidadaosList()
    {
        return Cidadao::with(['endereco', 'contato'])->get()->sortBy('nome');
    }

    public function getCidadaoDetail($id)
    {
        $cidadao = Cidadao::with(['endereco', 'contato'])->find($id);
        if ($cidadao) {
            return $cidadao;
        }
        return response()->json(['message' => 'Cidadão não encontrado.'], 404);
    }

    public function getCidadaoCPFDetail($cpf)
    {
        $cidadao = Cidadao::with(['endereco', 'contato'])
            ->where('cpf', '=', $cpf)
            ->first();
        if ($cidadao) {
            return $cidadao;
        }
        return response()->json(['message' => 'Cidadão não encontrado.'], 404);
    }

    public function postCidadaoCreate(Request $request)
    {

        $validator = Validator::make($request->json()->all(), [
            'nome' => 'required|max:255|min:2',
            'sobrenome' => 'required|max:255|min:2',
            'cpf' => 'required|unique:cidadaos|max:11|min:11',
            'email' => 'required|email|unique:contatos',
            'celular' => 'required|min:11|max:11|unique:contatos',
            'cep' => 'required|min:8|max:9'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->messages()
            ], 422);
        }

        $cep = $this->getEndereco($request->cep);

        if (!$cep) {
            return response()->json(['message' => 'CEP não encontrado.'], 404);
        }

        $cidadao = new Cidadao();
        $cidadao->nome = $request->nome;
        $cidadao->sobrenome = $request->sobrenome;
        $cidadao->cpf = $request->cpf;
        $cidadao->save();

        $contato = new Contato();
        $contato->email = $request->email;
        $contato->celular = $request->celular;
        $contato->cidadao_id = $cidadao->id;
        $contato->save();

        $endereco = new Endereco();
        $endereco->cep = $request->cep;
        $endereco->logradouro = $cep['logradouro'];
        $endereco->bairro = $cep['bairro'];
        $endereco->cidade = $cep['cidade'];
        $endereco->uf = $cep['uf'];
        $endereco->cidadao_id = $cidadao->id;
        $endereco->save();


        return response()->json([Cidadao::with(['endereco', 'contato'])->find($cidadao->id)], 201);
    }


    public function putCidadaoEdit(Request $request, $id)
    {
        $dados = $request->json()->all();

        $validator = Validator::make($dados, [
            'nome' => 'max:255|min:2',
            'sobrenome' => 'max:255|min:2',
            'cpf' => 'unique:cidadaos|max:11|min:11',
            'email' => 'email|unique:contatos',
            'celular' => 'min:11|max:11|unique:contatos'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->messages()
            ], 422);
        }

        $cidadao = Cidadao::find($id);
        $cidadao->nome = isset($dados["nome"]) ? $dados["nome"] : $cidadao->nome;
        $cidadao->sobrenome = isset($dados["sobrenome"]) ? $dados["sobrenome"] : $cidadao->sobrenome;
        $cidadao->cpf = isset($dados["cpf"]) ? $dados["cpf"] : $cidadao->cpf;
        $cidadao->save();

        if (isset($dados['contato'])) {
            $contato = Contato::where('cidadao_id', '=', $id)->first();
            $contato->email = isset($dados['contato']["email"]) ? $dados['contato']["email"] : $contato->email;
            $contato->celular = isset($dados['contato']["celular"]) ? $dados['contato']["celular"] : $contato->celular;
            $contato->save();
        }

        if (isset($dados['endereco'])) {

            if (isset($dados["endereco"]["cep"])) {
                $cep = $this->getEndereco($dados["endereco"]["cep"]);

                if ($cep) {
                    $endereco = Endereco::where('cidadao_id', '=', $id)->first();
                    $endereco->cep = $cep["cep"];
                    $endereco->logradouro = isset($dados["endereco"]["logradouro"]) && $cep['logradouro'] == null ? $dados["endereco"]["logradouro"] : $cep['logradouro'];
                    $endereco->bairro = isset($dados["endereco"]["bairro"]) && $cep['bairro'] ? $dados["endereco"]["bairro"] : $cep['bairro'];
                    $endereco->cidade = isset($dados["endereco"]["cidade"]) && $cep['cidade'] ? $dados["endereco"]["cidade"] : $cep['cidade'];
                    $endereco->uf = isset($dados["endereco"]["uf"]) && $cep['uf'] == null ? $dados["endereco"]["uf"] : $cep['uf'];;
                    $endereco->cidadao_id = $cidadao->id;
                    $endereco->save();
                }
            } else {
                return response()->json(["message" => "Informar o CEP"], 404);
            }
        }

        return response()->json(Cidadao::with(['endereco', 'contato'])->find($id), 200);
    }


    public function deleteCidadao($id)
    {
        $cidadao =  Cidadao::find($id);

        if (!$cidadao) {
            return response()->json(["message" => "Cidadão não encontrado."], 404);
        }

        $cidadao->delete();
        return response()->json(["message" => "Cidadão deletado."], 200);
    }



    //Busca o endereço pelo CEP na api ViaCep
    public function getEndereco($cep)
    {

        $response = Http::get("https://viacep.com.br/ws/" . $cep . "/json/");

        if (isset($response->json()['cep'])) {

            $dados['cep'] = $response->json()['cep'];
            $dados['logradouro'] = $response->json()['logradouro'] != "" ? $response->json()['logradouro'] : null;
            $dados['bairro'] = $response->json()['bairro'] != "" ? $response->json()['bairro'] : null;
            $dados['cidade'] = $response->json()['localidade'];
            $dados['uf'] = $response->json()['uf'];

            return $dados;
        } else {
            return false;
        }
    }
}
