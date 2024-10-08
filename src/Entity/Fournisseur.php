<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
     * @ORM\OneToMany(targetEntity=Contrat::class, mappedBy="numFournisseur")
     */
    private $contrats;

    /**
     * @ORM\OneToMany(targetEntity=Convention::class, mappedBy="numFournisseur")
     */
    private $conventions;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeFournisseur;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
        $this->conventions = new ArrayCollection();
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

    /**
     * @return Collection|Contrat[]
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setNumFournisseur($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getNumFournisseur() === $this) {
                $contrat->setNumFournisseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Convention[]
     */
    public function getConventions(): Collection
    {
        return $this->conventions;
    }

    public function addConvention(Convention $convention): self
    {
        if (!$this->conventions->contains($convention)) {
            $this->conventions[] = $convention;
            $convention->setNumFournisseur($this);
        }

        return $this;
    }

    public function removeConvention(Convention $convention): self
    {
        if ($this->conventions->removeElement($convention)) {
            // set the owning side to null (unless already changed)
            if ($convention->getNumFournisseur() === $this) {
                $convention->setNumFournisseur(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }

    public function getCodeFournisseur(): ?int
    {
        return $this->codeFournisseur;
    }

    public function setCodeFournisseur(int $codeFournisseur): self
    {
        $this->codeFournisseur = $codeFournisseur;

        return $this;
    }
}
