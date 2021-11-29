<?php
namespace App\Application\Actions\Biblioteca;

use App\Application\Actions\Action;
use App\Domain\Biblioteca\LivroServiceOrm;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListarLivrosAction extends Action
{
    protected LivroServiceOrm $livroServiceOrm;

    /**
     * ListarLivrosAction constructor.
     *
     * @param \Psr\Log\LoggerInterface                $logger
     * @param \App\Domain\Biblioteca\LivroServiceOrm $livroServiceOrm
     */
    public function __construct(
        LoggerInterface $logger,
        LivroServiceOrm $livroServiceOrm
    ) {
        parent::__construct($logger);

        $this->livroServiceOrm = $livroServiceOrm;
    }


    protected function action(): Response
    {
        // Obter livros
        $livros = $this->livroServiceOrm->obterLivros();

        // Preparar dados dos livros para retornar ao usuário
        $dadosLivros = [];
        foreach ($livros as $livro) {
            $dadosLivros[] = [
                'id'      => $livro->getId(),
                'situacao' => $livro->getSituacao(),
                'numero_de_paginas' => $livro->getNumeroDePaginas(),
                'ano' => $livro->getAno(),
                'titulo'    => $livro->getTitulo(),
                'autor' => $livro->getAutor(),
                'editora' => $livro->getEditora()
            ];
        }

        // Retonar dados ao usuário
        return $this->respondWithData($dadosLivros);
    }
}
