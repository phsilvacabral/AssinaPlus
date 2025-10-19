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

    // --- NOVOS CAMPOS ADICIONADOS ---
    #[Column(type: "string", length: 100)]
    private string $email;
    
    #[Column(type: "string", length: 100)]
    private string $senha;
    
    #[Column(type: "string", length: 100)]
    private string $tipo;
    
    #[Column(type: "string", length: 100, unique: true)] // Geralmente é único
    private string $nomeUsuario;
    
    #[Column(type: "boolean")]
    private bool $ativo;
    // ---------------------------------
    
    // --- RELACIONAMENTO: Muitos (Usuario) para Um (Setor) ---
    #[ManyToOne(targetEntity: Setor::class, inversedBy: "usuarios")]
    #[JoinColumn(name: "setor_id", referencedColumnName: "id", nullable: true)]
    private Setor $setor;
    
    // --- RELACIONAMENTO: Um (Usuario) para Um (QuadroAviso) - LADO DONO ---
    /**
     * @var QuadroAviso|null
     * Lado Dono: Usuario (UM) | Lado Inverso: QuadroAviso (UM)
     * mappedBy="usuario": Mapeia de volta para a entidade QuadroAviso.
     */
    #[OneToOne(mappedBy: "usuario", targetEntity: QuadroAviso::class, cascade: ["persist", "remove"])]
    private ?QuadroAviso $quadroAviso = null;


     // --- NOVO: Lado Inverso para Contratos como RESPONSÁVEL ---
    /**
     * @var Collection<int, Contrato>
     */
    #[OneToMany(mappedBy: "responsavel", targetEntity: Contrato::class)]
    private Collection $contratosResponsavel;

    // --- NOVO: Lado Inverso para Contratos como SOLICITANTE ---
    /**
     * @var Collection<int, Contrato>
     */
    #[OneToMany(mappedBy: "solicitante", targetEntity: Contrato::class)]
    private Collection $contratosSolicitante;

    public function __construct()
    {
        // Inicializações obrigatórias
        $this->contratosResponsavel = new ArrayCollection();
        $this->contratosSolicitante = new ArrayCollection();
        
        // ... [Outras inicializações de coleções existentes] ...
    }
    
    // --- Getters para as novas coleções (Responsável) ---
    /**
     * @return Collection<int, Contrato>
     */
    public function getContratosResponsavel(): Collection
    {
        return $this->contratosResponsavel;
    }

    // --- Getters para as novas coleções (Solicitante) ---
    /**
     * @return Collection<int, Contrato>
     */
    public function getContratosSolicitante(): Collection
    {
        return $this->contratosSolicitante;
    }
    
    // --- Getters e Setters (Antigos) ---

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

    // --- Getters e Setters (Novos para a relação Setor) ---

    public function getSetor(): Setor
    {
        return $this->setor;
    }

    public function setSetor(Setor $setor): void
    {
        $this->setor = $setor;
    }
    
    // --- Getters e Setters (Novos Campos) ---

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

    // --- Getters e Setters (Novos para a relação QuadroAviso) ---

    public function getQuadroAviso(): ?QuadroAviso
    {
        return $this->quadroAviso;
    }

    // Método para definir o quadro de aviso e garantir a bidirecionalidade
    public function setQuadroAviso(?QuadroAviso $quadroAviso): void
    {
        $this->quadroAviso = $quadroAviso;
        // Se o quadro existe e não tem este usuário definido, defina-o (garantindo a bidirecionalidade)
        if ($quadroAviso !== null && $quadroAviso->getUsuario() !== $this) {
            $quadroAviso->setUsuario($this);
        }
    }
}