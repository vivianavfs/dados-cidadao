<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CidadaoController;
use Illuminate\Http\Request;

class CreateCidadao extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:cidadao {nome : Nome do cidadão} 
    {sobrenome : Sobrenome do cidadão} 
    {cpf : CPF do cidadão}
    {email : E-mail do cidadão}
    {celular : Celular do cidadão}
    {cep : CEP do cidadão}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cadastra um cidadão no banco de dados.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $cidacao = [
            "nome" => $this->argument('nome'),
            "sobrenome" => $this->argument("sobrenome"),
            "cpf" => $this->argument("cpf"),
            "email" => $this->argument("email"),
            "celular" => $this->argument("celular"),
            "cep" => $this->argument("cep")
        ];

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->replace($cidacao);

        $controller = new CidadaoController();
        $cidacao_cadastrado = $controller->postCidadaoCreate($request);

        if (isset($cidacao_cadastrado->original)){
            return $this->comment(json_encode($cidacao_cadastrado->original));
        }

        return $this->comment($cidacao_cadastrado);
    }
}
