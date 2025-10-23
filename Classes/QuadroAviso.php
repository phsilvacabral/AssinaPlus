<?php

namespace AssinaPlus; 

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn; 
use Doctrine\ORM\Mapping\OneToMany;
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
    
    #[OneToOne(targetEntity: Usuario::class, inversedBy: "quadroAviso")]
    #[JoinColumn(name: "id_usuario", referencedColumnName: "id")] 
    private ?Usuario $usuario = null;

    #[OneToMany(mappedBy: "quadroAviso", targetEntity: Aviso::class)]
    private Collection $avisos;

    public function __construct()
    {
        $this->avisos = new ArrayCollection();
    }
    
    public function getIdQuadro(): ?int
    {
        return $this->idQuadro;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getAvisos(): Collection
    {
        return $this->avisos;
    }
    
    public function addAviso(Aviso $aviso): void
    {
        if (!$this->avisos->contains($aviso)) {
            $this->avisos->add($aviso);
            $aviso->setQuadroAviso($this);
        }
    }
}