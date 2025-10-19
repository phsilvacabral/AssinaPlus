<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne; // Para QuadroAviso (N:1)
use Doctrine\ORM\Mapping\JoinColumn; // Para QuadroAviso (N:1)

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
    
    // --- RELACIONAMENTO: Muitos (Aviso) para Um (QuadroAviso) - LADO DONO ---
    /**
     * @var QuadroAviso
     * Lado Dono: Aviso (MUITOS) | Lado Inverso: QuadroAviso (UM)
     * inversedBy="avisos": Mapeia de volta para a coleção na entidade QuadroAviso.
     */
    #[ManyToOne(targetEntity: QuadroAviso::class, inversedBy: "avisos")]
    #[JoinColumn(name: "id_quadro", referencedColumnName: "id_quadro")] // id_quadro é a FK
    private QuadroAviso $quadroAviso;

    // --- Getters e Setters ---
    
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

    // É crucial para manter a bidirecionalidade
    public function setQuadroAviso(QuadroAviso $quadroAviso): void
    {
        $this->quadroAviso = $quadroAviso;
    }
}