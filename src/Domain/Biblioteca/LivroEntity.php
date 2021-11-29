<?php
namespace App\Domain\Biblioteca;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="livros")
 */
class LivroEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid", nullable=false)
     */
    protected string $id;

    /**
     * @ORM\Column(name="titulo", type="string", length=200, nullable=false)
     */
    protected string $titulo;

    /**
     * @ORM\Column(name="situacao", type="smallint", nullable=false)
     */
    protected int $situacao;

    /**
     * @ORM\Column(name="ano", type="smallint", nullable=false)
     */

    protected string $ano;
    /**
     * @ORM\Column(name="numero_de_paginas", type="smallint", nullable=false)
     */
    protected string $numero_de_paginas;

    /**
     * @ORM\Column(name="autor", type="string",  length=200, nullable=false)
     */
    protected string $autor;

    /**
     * @ORM\Column(name="editora", type="string",  length=200, nullable=false)
     */
    protected string $editora;


    /**
     * LivroEntity constructor.
     *
     * @param string $titulo
     * @param string $autor
     * @param string $editora
     * @param int $ano
     * @param int $situacao
     * @param int $numero_de_paginas
     */
    public function __construct(
        string $titulo,
        string $autor,
        string $editora,
        int $situacao,
        int $ano,
        int $numero_de_paginas
    ) {
        $this->id = Uuid::uuid4();
        $this->titulo = $titulo;
        $this->editora = $editora;
        $this->autor = $autor;
        $this->ano = $ano;
        $this->situacao = $situacao;
        $this->numero_de_paginas = $numero_de_paginas;
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
     * @return LivroEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     *
     * @return LivroEntity
     */
    public function setTitulo(string $titulo): LivroEntity
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return float
     */
    public function getSituacao(): int
    {
        return $this->situacao;
    }

    /**
     * @param float $situacao
     *
     * @return LivroEntity
     */
    public function setSituacao(int $situacao): LivroEntity
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get the value of editora
     */ 
    public function getEditora()
    {
        return $this->editora;
    }

    /**
     * Set the value of editora
     *
     * @return  self
     */ 
    public function setEditora(string $editora)
    {
        $this->editora = $editora;

        return $this;
    }

    /**
     * Get the value of autor
     */ 
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set the value of autor
     *
     * @return  self
     */ 
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get the value of ano
     */ 
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set the value of ano
     *
     * @return  self
     */ 
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get the value of numero_de_paginas
     */ 
    public function getNumeroDePaginas()
    {
        return $this->numero_de_paginas;
    }

    /**
     * Set the value of numero_de_paginas
     *
     * @return  self
     */ 
    public function setNumeroDePaginas($numero_de_paginas)
    {
        $this->numero_de_paginas = $numero_de_paginas;

        return $this;
    }
}
