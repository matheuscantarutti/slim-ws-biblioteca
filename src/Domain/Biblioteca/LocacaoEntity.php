<?php
namespace App\Domain\Biblioteca;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="locacoes")
 */
class LocacaoEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid", nullable=false)
     */
    protected string $id;

    /**
     * @ORM\JoinColumn(name="livro_id")
     * @ORM\ManyToOne(targetEntity="LivroEntity")
     */
    protected LivroEntity $livro;


    /**
     * @ORM\Column(name="nome_locador", type="string", length=200, nullable=false)
     */
    protected string $nome_locador;

    /**
     * @ORM\Column(name="data_locacao", type="datetime",  nullable=false)
     */
    protected  $data_locacao;


    /**
     * @ORM\Column(name="data_devolucao", type="datetime",  nullable=false)
     */
    protected $data_devolucao;
    /**
     * @ORM\Column(name="data_entrega", type="datetime",  nullable=true)
     */
    protected  $data_entrega;

    /**
     * LocacaoEntity constructor.
     *
     * @param \App\Domain\Biblioteca\LivroEntity $livro
     * @param string                               $nome_locador
     * @param DateTime                                 $data_locacao
     * @param DateTime                                 $data_devolucao
     * @param DateTime                                 $data_entrega
     
     */
    public function __construct(
        LivroEntity $livro,
        string $nome_locador,

        DateTime $data_locacao,
        DateTime $data_devolucao
    ){
        $this->id = Uuid::uuid4();
        $this->livro = $livro;
        $this->nome_locador = $nome_locador;
        $this->data_devolucao = $data_devolucao;
        $this->data_locacao = $data_locacao;
       
    }


    /* GETTERS/SETTERS */

    /**
     * @return \Ramsey\Uuid\UuidInterface|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface|string $id
     *
     * @return LocacaoEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \App\Domain\Biblioteca\LivroEntity
     */
    public function getLivro(): LivroEntity
    {
        return $this->livro;
    }

    /**
     * @param \App\Domain\Biblioteca\LivroEntity $livro
     *
     * @return LocacaoEntity
     */
    public function setLivro(LivroEntity $livro): LocacaoEntity
    {
        $this->livro = $livro;

        return $this;
    }

    

    /**
     * Get the value of nome_locador
     */ 
    public function getNomeLocador()
    {
        return $this->nome_locador;
    }

    /**
     * Set the value of nome_locador
     *
     * @return  self
     */ 
    public function setNomeLocador($nome_locador)
    {
        $this->nome_locador = $nome_locador;

        return $this;
    }

    /**
     * Get the value of data_locacao
     */ 
    public function getDataLocacao()
    {
        return $this->data_locacao;
    }

    /**
     * Set the value of data_locacao
     *
     * @return  self
     */ 
    public function setDataLocacao($data_locacao)
    {
        $this->data_locacao = $data_locacao;

        return $this;
    }

    /**
     * Get the value of data_devolucao
     */ 
    public function getDataDevolucao()
    {
        return $this->data_devolucao;
    }

    /**
     * Set the value of data_devolucao
     *
     * @return  self
     */ 
    public function setDataDevolucao($data_devolucao)
    {
        $this->data_devolucao = $data_devolucao;

        return $this;
    }

    /**
     * Get the value of data_entrega
     */ 
    public function getDataEntrega()
    {
        return $this->data_entrega;
    }

    /**
     * Set the value of data_entrega
     *
     * @return  self
     */ 
    public function setDataEntrega($data_entrega)
    {
        $this->data_entrega = $data_entrega;

        return $this;
    }
}
