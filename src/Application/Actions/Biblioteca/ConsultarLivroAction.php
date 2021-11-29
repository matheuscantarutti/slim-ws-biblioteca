<?php
namespace App\Application\Actions\Biblioteca;

use App\Application\Actions\Action;
use App\Domain\Biblioteca\LivroServiceOrm;
use App\Domain\Biblioteca\LocacaoServiceOrm;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ConsultarLivroAction extends Action
{
    protected LivroServiceOrm $livroServiceOrm;
    protected LocacaoServiceOrm $locacaoServiceOrm;

    /**
     * RealizarLivroAction constructor.
     *
     * @param \Psr\Log\LoggerInterface                   $logger
     * @param \App\Domain\Biblioteca\LivroServiceOrm $livroServiceOrm
     */
    public function __construct(
        LoggerInterface $logger,
        LivroServiceOrm $livroServiceOrm,
        LocacaoServiceOrm $locacaoServiceOrm
    ) {
        parent::__construct($logger);

        $this->livroServiceOrm = $livroServiceOrm;
        $this->locacaoServiceOrm = $locacaoServiceOrm;
    }


    protected function action(): Response
    {
        // Obter id do livro a ser consultada
        $id = $this->resolveArg('id');

        // Obter livro
        try {
            $livro = $this->livroServiceOrm->obterLivroPorId($id);
            $locacoes = $this->locacaoServiceOrm->obterLocacoesPorLivroId($livro);

            // Retornar os dados da livro
            $retorno = [
                'id'      => $livro->getId(),
                'situacao' => $livro->getSituacao(),
                'numero_de_paginas' => $livro->getNumeroDePaginas(),
                'ano' => $livro->getAno(),
                'titulo'    => $livro->getTitulo(),
                'autor' => $livro->getAutor(),
                'editora' => $livro->getEditora(),
                'locacoes' => $locacoes
            ];

            // Retonar dados ao usuário
            return $this->respondWithData($retorno);

        } catch (\Exception $e) {
            $this->response->getBody()->write($e->getMessage());

            return $this->response->withStatus(404);
        }
    }
}
