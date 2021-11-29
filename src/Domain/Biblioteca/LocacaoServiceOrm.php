<?php
namespace App\Domain\Biblioteca;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;



class LocacaoServiceOrm
{
    protected EntityManagerInterface $em;
    protected ObjectRepository $repositoryLocacao;

    /**
     * LocacaoServiceOrm constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->repositoryLocacao = $this->em->getRepository(LocacaoEntity::class);
    }


    /**
     * 
     *
     * @return \App\Domain\Biblioteca\LocacaoEntity[]|object[]|null
     */
    public function obterLocacoesPorLivroId(LivroEntity $livro)
    {
        $criteria = new Criteria();

        $criteria->andWhere(
            $criteria->expr()->eq('livro', $livro)
        );
        

        return $this->em->getRepository(LocacaoEntity::class)->matching($criteria)->toArray();
    }

    /**
     * @param string $idLocacao
     *
     * @return \App\Domain\Biblioteca\LocacaoEntity|null
     * @throws \Exception
     */
    public function obterLocacaoPorId(string $idLocacao): ?LocacaoEntity
    {
        /**
         * @var \App\Domain\Biblioteca\LocacaoEntity $transacao
         */

        $transacao = $this->em->getRepository(LocacaoEntity::class)->find($idLocacao);

        if (!$transacao) {
            throw new Exception('Transação não encontrada');
        }

        return $transacao;
    }


    public function inserirLocacao(LivroEntity $livro, $data_locacao, string $nome_locador, $data_devolucao): LocacaoEntity
    {

        $livro->setSituacao(3);

        $novaLocacao = new LocacaoEntity(
            $livro,
            $nome_locador,
            $data_locacao,
            $data_devolucao
        );

        $this->em->persist($novaLocacao);
        $this->em->flush();

        return $novaLocacao;
    }
   
    public function devolucao(LocacaoEntity $locacao, $data_entrega): LocacaoEntity
    {

        $locacao->setDataEntrega($data_entrega);
        $locacao->getLivro()->setSituacao(1);

        $novaLocacao = $locacao;

        $this->em->persist($novaLocacao);
        $this->em->flush();

        return $novaLocacao;
    }

    
}
