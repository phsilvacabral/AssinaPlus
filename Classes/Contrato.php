<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne; // Para os dois relacionamentos N:1
use Doctrine\ORM\Mapping\JoinColumn; // Para as chaves estrangeiras
use Doctrine\ORM\Mapping\OneToMany; // Para a relação 1:N com Documento
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[Entity]
#[Table(name: "contrato")]
class Contrato
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: "id_contrato", type: "integer")]
    private ?int $idContrato = null;

    #[Column(type: "string", length: 100)]
    private string $nome;

    #[Column(name: "data_inicio", type: "date")]
    private \DateTimeInterface $dataInicio;

    #[Column(name: "data_fim", type: "date", nullable: true)]
    private ?\DateTimeInterface $dataFim = null;
    
    // --- RELACIONAMENTO 1: Responsável (Muitos Contratos para Um Usuário) ---
    /**
     * @var Usuario
     * Lado Dono: Contrato (MUITOS) | Lado Inverso: Usuario (UM)
     * Referencia o Usuario que é o RESPONSÁVEL pelo contrato.
     */
    #[ManyToOne(targetEntity: Usuario::class, inversedBy: "contratosResponsavel")]
    #[JoinColumn(name: "id_responsavel", referencedColumnName: "id", nullable: false)]
    private Usuario $responsavel;

    // --- RELACIONAMENTO 2: Solicitante (Muitos Contratos para Um Usuário) ---
    /**
     * @var Usuario
     * Lado Dono: Contrato (MUITOS) | Lado Inverso: Usuario (UM)
     * Referencia o Usuario que é o SOLICITANTE do contrato.
     */
    #[ManyToOne(targetEntity: Usuario::class, inversedBy: "contratosSolicitante")]
    #[JoinColumn(name: "id_solicitante", referencedColumnName: "id", nullable: false)]
    private Usuario $solicitante;
    
    // --- RELACIONAMENTO 3: Contrato (1) para Documento (N) ---
    /**
     * @var Collection<int, Documento>
     * Lado Dono: Contrato (UM) | Lado Inverso: Documento (MUITOS)
     */
    #[OneToMany(mappedBy: "contrato", targetEntity: Documento::class)]
    private Collection $documentos;

    public function __construct()
    {
        $this->documentos = new ArrayCollection();
    }
    
    // --- Getters e Setters ---

    public function getIdContrato(): ?int
    {
        return $this->idContrato;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getDataInicio(): \DateTimeInterface
    {
        return $this->dataInicio;
    }

    public function setDataInicio(\DateTimeInterface $dataInicio): void
    {
        $this->dataInicio = $dataInicio;
    }

    public function getDataFim(): ?\DateTimeInterface
    {
        return $this->dataFim;
    }

    public function setDataFim(?\DateTimeInterface $dataFim): void
    {
        $this->dataFim = $dataFim;
    }

    public function getResponsavel(): Usuario
    {
        return $this->responsavel;
    }

    public function setResponsavel(Usuario $responsavel): void
    {
        $this->responsavel = $responsavel;
    }

    public function getSolicitante(): Usuario
    {
        return $this->solicitante;
    }

    public function setSolicitante(Usuario $solicitante): void
    {
        $this->solicitante = $solicitante;
    }
    
    /**
     * @return Collection<int, Documento>
     */
    public function getDocumentos(): Collection
    {
        return $this->documentos;
    }

    // Método para adicionar Documento e garantir a bidirecionalidade
    public function addDocumento(Documento $documento): void
    {
        if (!$this->documentos->contains($documento)) {
            $this->documentos->add($documento);
            $documento->setContrato($this);
        }
    }
}