<?php

// IMPORTANTE: Use o namespace que você definiu no composer.json
namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[Entity]
#[Table(name: "setor")]
class Setor
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private ?int $id = null;

    #[Column(type: "string", length: 100)]
    private string $nome;

    /**
     * @var Collection<int, Usuario>
     * Lado Dono: Setor (UM) | Lado Inverso: Usuario (MUITOS)
     * mappedBy="setor": Indica que o campo "setor" na classe Usuario é o lado dono da relação.
     */
    #[OneToMany(mappedBy: "setor", targetEntity: Usuario::class)]
    private Collection $usuarios;

    public function __construct()
    {
        // É obrigatório inicializar coleções em construtores
        $this->usuarios = new ArrayCollection();
    }
    
    // --- Getters e Setters ---
    
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

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    // Método para adicionar um usuário e garantir a bidirecionalidade
    public function addUsuario(Usuario $usuario): void
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->setSetor($this);
        }
    }
}