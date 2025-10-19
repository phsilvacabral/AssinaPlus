<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToOne; // Para Usuario (1:1)
use Doctrine\ORM\Mapping\JoinColumn; // Para Usuario (1:1)
use Doctrine\ORM\Mapping\OneToMany; // Para Aviso (1:N)
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[Entity]
#[Table(name: "quadro_aviso")]
class QuadroAviso
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: "id_quadro", type: "integer")]
    private ?int $idQuadro = null;
    
    // --- RELACIONAMENTO: Um (QuadroAviso) para Um (Usuario) - LADO INVERSO ---
    /**
     * @var Usuario
     * Lado Dono: Usuario (UM) | Lado Inverso: QuadroAviso (UM)
     * inversedBy="quadroAviso": Mapeia de volta para o campo 'quadroAviso' na entidade Usuario.
     */
    #[OneToOne(targetEntity: Usuario::class, inversedBy: "quadroAviso")]
    #[JoinColumn(name: "id_usuario", referencedColumnName: "id")] // id_usuario é a FK
    private ?Usuario $usuario = null;
    
    // --- RELACIONAMENTO: Um (QuadroAviso) para Muitos (Aviso) ---
    /**
     * @var Collection<int, Aviso>
     * Lado Dono: QuadroAviso (UM) | Lado Inverso: Aviso (MUITOS)
     * mappedBy="quadroAviso": Indica que o campo "quadroAviso" na classe Aviso é o lado dono.
     */
    #[OneToMany(mappedBy: "quadroAviso", targetEntity: Aviso::class)]
    private Collection $avisos;

    public function __construct()
    {
        // É obrigatório inicializar coleções
        $this->avisos = new ArrayCollection();
    }

    // --- Getters e Setters ---
    
    public function getIdQuadro(): ?int
    {
        return $this->idQuadro;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    // É crucial para manter a bidirecionalidade (1:1)
    public function setUsuario(Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Collection<int, Aviso>
     */
    public function getAvisos(): Collection
    {
        return $this->avisos;
    }
    
    // Método para adicionar um Aviso e garantir a bidirecionalidade
    public function addAviso(Aviso $aviso): void
    {
        if (!$this->avisos->contains($aviso)) {
            $this->avisos->add($aviso);
            $aviso->setQuadroAviso($this);
        }
    }
}