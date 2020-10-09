<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $communes_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lien;

    /**
     * @ORM\ManyToOne(targetEntity=Communes::class, inversedBy="medias")
     */
    private $communes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunesId(): ?int
    {
        return $this->communes_id;
    }

    public function setCommunesId(int $communes_id): self
    {
        $this->communes_id = $communes_id;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getCommunes(): ?Communes
    {
        return $this->communes;
    }

    public function setCommunes(?Communes $communes): self
    {
        $this->communes = $communes;

        return $this;
    }
}
