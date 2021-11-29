<?php
declare(strict_types=1);

use App\Application\Actions\Biblioteca\ConsultarLivroAction;
use App\Application\Actions\Biblioteca\ListarLivrosAction;
use App\Application\Actions\Biblioteca\RealizarLocacaoAction;
use App\Application\Actions\Biblioteca\AlterarLocacaoAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('API Biblioteca');
        return $response;
    });

    // Rotas da API de Biblioteca
    $app->get('/livros', ListarLivrosAction::class);

    $app->get('/livros/{id}', ConsultarLivroAction::class);

    $app->post('/locacoes', RealizarLocacaoAction::class);

    $app->put('/locacoes', AlterarLocacaoAction::class);
};
