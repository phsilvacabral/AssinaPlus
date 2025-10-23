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
#[Table(name: "documento")]
class Documento
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: "id_documento", type: "integer")]
    private ?int $idDocumento = null;

    #[Column(type: "string", length: 100)]
    private string $nome;

    #[Column(type: "string", length: 100)]
    private string $arquivo;
    
    #[ManyToOne(targetEntity: Contrato::class, inversedBy: "documentos")]
    #[JoinColumn(name: "id_contrato", referencedColumnName: "id_contrato", nullable: false)]
    private Contrato $contrato;

    public function getIdDocumento(): ?int
    {
        return $this->idDocumento;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getArquivo(): string
    {
        return $this->arquivo;
    }

    public function setArquivo(string $arquivo): void
    {
        $this->arquivo = $arquivo;
    }

    public function getContrato(): Contrato
    {
        return $this->contrato;
    }

    public function setContrato(Contrato $contrato): void
    {
        $this->contrato = $contrato;
    }
}