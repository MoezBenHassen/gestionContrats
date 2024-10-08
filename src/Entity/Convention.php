<?php

namespace App\Entity;

use App\Repository\ConventionRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ConventionRepository::class)
 * @Vich\Uploadable
 */
class Convention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="conventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libellePDF;

    /**
     * @Vich\UploadableField(mapping="conventionUpload", fileNameProperty="libellePDF")
     */
    private $filePDF;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;
    
    public function __construct()
    {
        $this->updatedAt = new DateTime();
    }

    public function getfilePDF(): ?File
    {
        return $this->filePDF;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $filePDF
     */
    public function setfilePDF(?File $filePDF = null): void
    {
        $this->filePDF = $filePDF;

        if(null !== $filePDF) {
            $this->updatedAt = new DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getNumFournisseur(): ?Fournisseur
    {
        return $this->numFournisseur;
    }

    public function setNumFournisseur(?Fournisseur $numFournisseur): self
    {
        $this->numFournisseur = $numFournisseur;

        return $this;
    }

    public function getLibellePDF()
    {
        return $this->libellePDF;
    }

    public function setLibellePDF($libellePDF): self
    {
        $this->libellePDF = $libellePDF;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }
}
