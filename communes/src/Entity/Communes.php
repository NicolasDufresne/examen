<?php

namespace App\Entity;

use App\Repository\CommunesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunesRepository::class)
 * @ORM\HasLifecycleCallbacks()
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

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="communes", cascade={"persist","remove"})
     */
    private $medias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function modifySlug()
    {
        $slugify = new Slugify();
        $this->slug = $this->getNom();

        $this->slug = $slugify->slugify($this->getNom());
    }

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

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setCommunes($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
            // set the owning side to null (unless already changed)
            if ($media->getCommunes() === $this) {
                $media->setCommunes(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
