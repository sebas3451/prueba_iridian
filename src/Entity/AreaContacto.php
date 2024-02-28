<?php

namespace App\Entity;

use App\Repository\AreaContactoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AreaContactoRepository::class)]
class AreaContacto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nombre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }   

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}