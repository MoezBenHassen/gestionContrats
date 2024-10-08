<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 * @Vich\Uploadable
 */
class Contrat
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
     * @ORM\Column(type="integer")
     */
    private $preavis;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="integer")
     */
    private $numEnregistrement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periodiciteEntretien;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periodiciteFacturation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $augmentation;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libellePDF;

    /**
     * @Vich\UploadableField(mapping="contratUpload", fileNameProperty="libellePDF")
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

    /**
     * @ORM\ManyToOne(targetEntity=TypesContrat::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $suivi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $repetitive;
    
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

    public function getPreavis(): ?int
    {
        return $this->preavis;
    }

    public function setPreavis(int $preavis): self
    {
        $this->preavis = $preavis;

        return $this;
    }

    public function getType(): ?TypesContrat
    {
        return $this->Type;
    }

    public function setType(?TypesContrat $type): self
    {
        $this->Type = $type;

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

    public function getNumEnregistrement(): ?int
    {
        return $this->numEnregistrement;
    }

    public function setNumEnregistrement(int $numEnregistrement): self
    {
        $this->numEnregistrement = $numEnregistrement;

        return $this;
    }

    public function getPeriodiciteEntretien(): ?string
    {
        return $this->periodiciteEntretien;
    }

    public function setPeriodiciteEntretien(string $periodiciteEntretien): self
    {
        $this->periodiciteEntretien = $periodiciteEntretien;

        return $this;
    }

    public function getPeriodiciteFacturation(): ?string
    {
        return $this->periodiciteFacturation;
    }

    public function setPeriodiciteFacturation(string $periodiciteFacturation): self
    {
        $this->periodiciteFacturation = $periodiciteFacturation;

        return $this;
    }

    public function getAugmentation(): ?float
    {
        return $this->augmentation;
    }

    public function setAugmentation(?float $augmentation): self
    {
        $this->augmentation = $augmentation;

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

    public function getSuivi(): ?bool
    {
        return $this->suivi;
    }

    public function setSuivi(bool $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }

    public function getRepetitive(): ?bool
    {
        return $this->repetitive;
    }

    public function setRepetitive(bool $repetitive): self
    {
        $this->repetitive = $repetitive;

        return $this;
    }
}
