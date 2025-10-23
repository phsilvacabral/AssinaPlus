<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne; 
use Doctrine\ORM\Mapping\JoinColumn; 

#[Entity]
#[Table(name: "aviso")]
class Aviso
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: "id_aviso", type: "integer")]
    private ?int $idAviso = null;

    #[Column(type: "string", length: 100)]
    private string $nome;
    
    #[Column(type: "string", length: 100)]
    private string $descricao;

    #[Column(type: "string", length: 100)]
    private string $status;
    
    #[ManyToOne(targetEntity: QuadroAviso::class, inversedBy: "avisos")]
    #[JoinColumn(name: "id_quadro", referencedColumnName: "id_quadro")] 
    private QuadroAviso $quadroAviso;
    
    public function getIdAviso(): ?int
    {
        return $this->idAviso;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getQuadroAviso(): QuadroAviso
    {
        return $this->quadroAviso;
    }

    public function setQuadroAviso(QuadroAviso $quadroAviso): void
    {
        $this->quadroAviso = $quadroAviso;
    }
}