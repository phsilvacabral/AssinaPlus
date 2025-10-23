<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne; 
use Doctrine\ORM\Mapping\InverseJoinColumn; 

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;

#[Entity]
#[Table(name: "usuario")]
class Usuario
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private ?int $id = null;

    #[Column(type: "string", length: 255)]
    private string $nome;

    #[Column(type: "string", length: 100)]
    private string $email;
    
    #[Column(type: "string", length: 100)]
    private string $senha;
    
    #[Column(type: "string", length: 100)]
    private string $tipo;
    
    #[Column(type: "string", length: 100, unique: true)] 
    private string $nomeUsuario;
    
    #[Column(type: "boolean")]
    private bool $ativo;
    
    #[ManyToOne(targetEntity: Setor::class, inversedBy: "usuarios")]
    #[JoinColumn(name: "setor_id", referencedColumnName: "id", nullable: true)]
    private Setor $setor;

    #[OneToOne(mappedBy: "usuario", targetEntity: QuadroAviso::class, cascade: ["persist", "remove"])]
    private ?QuadroAviso $quadroAviso = null;

    #[OneToMany(mappedBy: "responsavel", targetEntity: Contrato::class)]
    private Collection $contratosResponsavel;

    #[OneToMany(mappedBy: "solicitante", targetEntity: Contrato::class)]
    private Collection $contratosSolicitante;

    public function __construct()
    {
        $this->contratosResponsavel = new ArrayCollection();
        $this->contratosSolicitante = new ArrayCollection();
        
    }

    public function getContratosResponsavel(): Collection
    {
        return $this->contratosResponsavel;
    }

    public function getContratosSolicitante(): Collection
    {
        return $this->contratosSolicitante;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getSetor(): Setor
    {
        return $this->setor;
    }

    public function setSetor(Setor $setor): void
    {
        $this->setor = $setor;
    }
 
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getNomeUsuario(): string
    {
        return $this->nomeUsuario;
    }

    public function setNomeUsuario(string $nomeUsuario): void
    {
        $this->nomeUsuario = $nomeUsuario;
    }

    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void
    {
        $this->ativo = $ativo;
    }

    public function getQuadroAviso(): ?QuadroAviso
    {
        return $this->quadroAviso;
    }

    public function setQuadroAviso(?QuadroAviso $quadroAviso): void
    {
        $this->quadroAviso = $quadroAviso;
        if ($quadroAviso !== null && $quadroAviso->getUsuario() !== $this) {
            $quadroAviso->setUsuario($this);
        }
    }
}