<?php

namespace App\Application\Actions\Biblioteca;

use App\Application\Actions\Action;
use App\Domain\Biblioteca\LivroServiceOrm;
use App\Domain\Biblioteca\LocacaoServiceOrm;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use DateTime;

class AlterarLocacaoAction extends Action
{
    protected LivroServiceOrm $livroServiceOrm;
    protected LocacaoServiceOrm $locacaoServiceOrm;

    /**
     * AlterarLocacaoAction constructor.
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

        $locacao = $this->locacaoServiceOrm->obterLocacaoPorId($dadosLocacao['id']);

        if (!$locacao) {
            $retorno['msg'] = 'Locacao Inexistente';

            return $this->respondWithData($retorno);
        }


        $inicio = $locacao->getDataLocacao();
        $fim = new DateTime($dadosLocacao['data_entrega']);
        $intervalo = $inicio->diff($fim);

        if ($intervalo->d <= 0) {
            $retorno['msg'] = 'Data de entrega incorreta';

            return $this->respondWithData($retorno);
        }

        try {
            $novaLocacao = $this->locacaoServiceOrm->devolucao(
               $locacao,
               new DateTime($dadosLocacao['data_entrega'])
            );

            $retorno['dados'] = $novaLocacao;
            $retorno['status'] = true;
            $retorno['msg'] = "Devolução realizada com sucesso!";

        } catch (\Exception $exception) {
            $retorno['msg'] = $exception->getMessage();
        }

        // Retonar dados ao usuário
        return $this->respondWithData($retorno);
    }
}
