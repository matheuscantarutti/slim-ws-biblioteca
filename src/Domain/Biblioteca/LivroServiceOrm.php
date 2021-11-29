<?php
namespace App\Domain\Biblioteca;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;

class LivroServiceOrm
{
    protected EntityManagerInterface $em;
    protected ObjectRepository $repositoryLivro;

    /**
     * LivroServiceOrm constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repositoryLivro = $this->em->getRepository(LivroEntity::class);

    }

    /**
     * @return \App\Domain\Biblioteca\LivroEntity[]
     */
    public function obterLivros(): array
    {
        /**
         * @var \App\Domain\Biblioteca\LivroEntity[] $livros
         */

        $livros = $this->repositoryLivro->findAll();

        return $livros;
    }

    /**
     * 
     *
     * @return \App\Domain\Biblioteca\LivroEntity|null
     * @throws \Exception
     */
    public function obterLivroPorId(string $id): ?LivroEntity
    {
        /**
         * @var \App\Domain\Biblioteca\LivroEntity $livro
         */

        $livro = $this->repositoryLivro->findOneBy([
            'id' => $id,
        ]);

        if (!$livro) {
            throw new Exception('Livro não encontrado');
        }

        return $livro;
    }

    /**
     * @param \App\Domain\Biblioteca\LivroEntity $livro
     * @param                                     $situacao
     *
     * @return \App\Domain\Biblioteca\LivroEntity
     */
    public function atualizarSituacaoLivro(LivroEntity $livro, $situacao): LivroEntity
    {
        $livro->setSituacao($situacao);

        $this->em->persist($livro);
        $this->em->flush();

        return $livro;
    }
}
