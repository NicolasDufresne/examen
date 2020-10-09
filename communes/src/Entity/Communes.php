<?php

namespace App\Entity;

use App\Repository\CommunesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunesRepository::class)
 */
class Communes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeDepartement;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeRegion;

    /**
     * @ORM\Column(type="integer")
     */
    private $codesPostaux;

    /**
     * @ORM\Column(type="integer")
     */
    private $population;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCodeDepartement(): ?int
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(int $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getCodeRegion(): ?int
    {
        return $this->codeRegion;
    }

    public function setCodeRegion(int $codeRegion): self
    {
        $this->codeRegion = $codeRegion;

        return $this;
    }

    public function getCodesPostaux(): ?int
    {
        return $this->codesPostaux;
    }

    public function setCodesPostaux(int $codesPostaux): self
    {
        $this->codesPostaux = $codesPostaux;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }
}
