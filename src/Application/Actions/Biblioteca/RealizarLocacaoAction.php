<?php

namespace App\Application\Actions\Biblioteca;

use App\Application\Actions\Action;
use App\Domain\Biblioteca\LivroServiceOrm;
use App\Domain\Biblioteca\LocacaoServiceOrm;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use DateTime;

class RealizarLocacaoAction extends Action
{
    protected LivroServiceOrm $livroServiceOrm;
    protected LocacaoServiceOrm $locacaoServiceOrm;

    /**
     * RealizarLocacaoAction constructor.
     *
     * @param \Psr\Log\LoggerInterface                   $logger
     * @param \App\Domain\Biblioteca\LivroServiceOrm    $livroServiceOrm
     * @param \App\Domain\Biblioteca\LocacaoServiceOrm $locacaoServiceOrm
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
        // Criar padrão de retorno
        $retorno = [
            'status' => false,
            'msg'    => '',
            'dados'  => null,
        ];

        
        $dadosLocacao = json_decode($this->request->getBody()->getContents(), true);


        foreach ($dadosLocacao as $key => $value) {

            if (empty($value)) {
                $retorno['msg'] = "Necessário informar $key";

                return $this->respondWithData($retorno);
            }
        }

        $livroExistente = $this->livroServiceOrm->obterLivroPorId($dadosLocacao['livro_id']);

        if (!$livroExistente) {
            $retorno['msg'] = 'Livro Inexistente';

            return $this->respondWithData($retorno);
        }

        if($livroExistente['situacao'] != 1){
            $retorno['msg'] = 'Livro indisponível';

            return $this->respondWithData($retorno);
        }


        $inicio = new DateTime($dadosLocacao['data_locacao']);
        $fim = new DateTime($dadosLocacao['data_devolucao']);
        $intervalo = $inicio->diff($fim);

        if ($intervalo->d != 3) {
            $retorno['msg'] = 'Prazo de devoluçao deve ser de 3 dias';

            return $this->respondWithData($retorno);
        }

        try {
            $novaLocacao = $this->locacaoServiceOrm->inserirLocacao(
                $livroExistente,
                new DateTime($dadosLocacao['data_locacao']),
                $dadosLocacao['nome_locador'],
                new DateTime($dadosLocacao['data_devolucao'])
            );

            $retorno['dados'] = $novaLocacao;
            $retorno['status'] = true;
            $retorno['msg'] = "Locação inserida com sucesso!";

        } catch (\Exception $exception) {
            $retorno['msg'] = $exception->getMessage();
        }

        // Retonar dados ao usuário
        return $this->respondWithData($retorno);
    }
}
