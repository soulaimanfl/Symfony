<?php

namespace App\Entity;
ini_set('memory_limit', '700M'); // Increase to 256MB or more as needed

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;




#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[Assert\NotBlank(message: "L'appellation officielle est obligatoire.")]
    #[ORM\Column(type: 'string', length: 255)]
    private $appellationOfficielle;

    #[ORM\Column(type: 'string', length: 255)]
    private $denominationPrincipale;




    #[Assert\NotBlank(message: "Le secteur est obligatoire.")]
    #[Assert\Choice(choices: ["public", "privé"], message: "Choisissez un secteur valide.")]
    #[ORM\Column(type: 'string', length: 255)]
    private $secteur;


    #[Assert\Date(message: "Entrez une date valide.")]

    #[ORM\Column(type: 'datetime')]
    private $dateOuverture;


    #[ORM\Column(type: 'float')]
    private $longitude;

    #[ORM\Column(type: 'float')]
    private $latitude;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $departement;

    #[ORM\Column(type: 'string', length: 255)]
    private $commune;

    #[ORM\Column(type: 'string', length: 255)]
    private $region;

    #[ORM\Column(type: 'string', length: 255)]
    private $academie;


    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Commentaire::class, cascade: ['persist', 'remove'])]
    private Collection $commentaires;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppellationOfficielle(): ?string
    {
        return $this->appellationOfficielle;
    }

    public function setAppellationOfficielle(string $appellationOfficielle): self
    {
        $this->appellationOfficielle = $appellationOfficielle;

        return $this;
    }

    public function getDenominationPrincipale(): ?string
    {
        return $this->denominationPrincipale;
    }

    public function setDenominationPrincipale(string $denominationPrincipale): self
    {
        $this->denominationPrincipale = $denominationPrincipale;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }


    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getAcademie(): ?string
    {
        return $this->academie;
    }

    public function setAcademie(string $academie): self
    {
        $this->academie = $academie;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTimeInterface $dateOuverture): self
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEtablissement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtablissement() === $this) {
                $commentaire->setEtablissement(null);
            }
        }

        return $this;
    }

    public function setCommentaire(?Commentaire $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

}