<?php

use App\Http\Controllers\CidadaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [CidadaoController::class, 'getCidadaosList']);
Route::get('/{id}', [CidadaoController::class, 'getCidadaoDetail']);
Route::get('/cpf/{cpf}', [CidadaoController::class, 'getCidadaoCPFDetail']);

Route::post('/create', [CidadaoController::class, 'postCidadaoCreate']);

Route::put('/edit/{id}', [CidadaoController::class, 'putCidadaoEdit']);

Route::delete('/delete/{id}', [CidadaoController::class, 'deleteCidadao']);
