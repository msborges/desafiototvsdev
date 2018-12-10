<?php

require 'vendor/autoload.php';

$app = new Slim\App();

// LISTA TODOS OS USUARIOS
$app->get('/usuarios', function($result, $response) use ($app){
    $result = (new \controllers\Usuario($app))->listaTodos();

    if (count($result) > 0) {
        $status = array(
            "status" => 1,
            "contador" => count($result),
            "message" => "Dados retornados com sucesso."
        );

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array_merge($result,$status)));
    }
    else{
        $status = array(
            "status" => 0,
            "message" => "Não existe resultado para essa busca."
        );
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($status));
    }
});

// LISTA UM USUARIO PELO SEU ID
$app->get('/usuario/{id}', function($request, $response, $result) use ($app){
    $idUsuario = $request->getAttribute('id');
    $result = (new \controllers\Usuario($app))->listaPorID($idUsuario);

    if (count($result) > 0) {
        $status = array(
            "status" => 1,
            "contador" => count($result),
            "message" => "Dados retornados com sucesso."
        );

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array_merge($result,$status)));
    }
    else{
        $status = array(
            "status" => 0,
            "message" => "Não existe resultado para essa busca."
        );
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($status));
    }
});

// CADASTRA UM NOVO USUARIO
$app->post('/usuarios/novo', function($request, $response) {
    $dados = json_decode($request->getBody(), true);

    $result = (new \controllers\Usuario())->novoUsuario($dados);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// ALTERA UM USUARIO PELO SEU ID
$app->put('/usuarios/{id}', function($request, $response) {
    $idUsuario = $request->getAttribute('id');
    $dados = json_decode($request->getBody(), true);

    $result = (new \controllers\Usuario())->editarUsuario($idUsuario, $dados);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// REMOVE UM USUARIO PELO ID
$app->put('/usuarios/remover/{id}', function($request, $response) {
    $idUsuario = $request->getAttribute('id');

    $result = (new \controllers\Usuario())->excluirUsuario($idUsuario);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// LISTA TODOS OS LEILOES
$app->get('/leiloes', function($result, $response) use ($app){
    $result = (new \controllers\Leilao($app))->listaTodos();

    if (count($result) > 0) {
        $status = array(
            "status" => 1,
            "contador" => count($result),
            "message" => "Dados retornados com sucesso."
        );

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array_merge($result,$status)));
    }
    else{
        $status = array(
            "status" => 0,
            "message" => "Não existe resultado para essa busca."
        );
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($status));
    }
});

// LISTA UM LEILAO PELO SEU ID
$app->get('/leilao/{id}', function($request, $response, $result) use ($app){
    $idLeilao = $request->getAttribute('id');
    $result = (new \controllers\Leilao($app))->listaPorID($idLeilao);

    if (count($result) > 0) {
        $status = array(
            "status" => 1,
            "contador" => count($result),
            "message" => "Dados retornados com sucesso."
        );

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array_merge($result,$status)));
    }
    else{
        $status = array(
            "status" => 0,
            "message" => "Não existe resultado para essa busca."
        );
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($status));
    }
});

// CADASTRA UM NOVO LEILAO
$app->post('/leiloes/novo', function($request, $response) {
    $dados = json_decode($request->getBody(), true);

    $result = (new \controllers\Leilao())->novoLeilao($dados);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// ALTERA UM LEILAO PELO SEU ID
$app->put('/leiloes/{id}', function($request, $response) {
    $idLeilao = $request->getAttribute('id');
    $dados = json_decode($request->getBody(), true);

    $result = (new \controllers\Leilao())->editarLeilao($idLeilao, $dados);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// REMOVE UM LEILAO PELO ID
$app->put('/leiloes/remover/{id}', function($request, $response) {
    $idLeilao = $request->getAttribute('id');

    $result = (new \controllers\Leilao())->excluirLeilao($idLeilao);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

// LISTA OS LANCES DE UM LEILAO PELO SEU ID
$app->get('/leilao/lances/{id}', function($request, $response, $result) use ($app){
    $idLeilao = $request->getAttribute('id');
    $result = (new \controllers\Lance($app))->listaTodosPorLeilaoID($idLeilao);

    if (count($result) > 0) {
        $status = array(
            "status" => 1,
            "contador" => count($result),
            "message" => "Dados retornados com sucesso."
        );

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array_merge($result,$status)));
    }
    else{
        $status = array(
            "status" => 0,
            "message" => "Não existe resultado para essa busca."
        );
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($status));
    }
});

// CADASTRA UM NOVO LANCE EM UM LEILAO
$app->post('/leiloes/lances/novo', function($request, $response) {
    $dados = json_decode($request->getBody(), true);

    $result = (new \controllers\Lance())->novoLancePorLeilao($dados);

    if (count($result) > 0 && $result["status"] == 1) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
    else{
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($result));
    }
});

$app->run();
