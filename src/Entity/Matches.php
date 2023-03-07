<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(length: 20)]
    private ?int $id_match = null;

    #[ORM\Column(length: 64)]
    private ?string $equipe_locale = null;

    #[ORM\Column(length: 1)]
    private ?int $domicile_exterieur = null;

    #[ORM\Column(length: 64)]
    private ?string $equipe_adverse = null;

    #[ORM\Column(length: 64,nullable: true,options: ['default' => null])]
    private ?string $hote = null;

    #[ORM\Column(nullable: true,options: ['default' => null])]
    private ?\DateTime $date_heure = null;

    #[ORM\Column(length: 11)]
    private ?int $num_semaine = null;

    #[ORM\Column(length: 11)]
    private ?int $num_journee = null;

    #[ORM\Column(length: 64,nullable: true,options: ['default' => null])]
    private ?string $gymnase;


    public function getId(): ?int
    {
        return $this->id_match;
    }

    public function getEquipeLocale(): ?string
    {
        return $this->equipe_locale;
    }

    public function setEquipeLocale(string $equipe_locale): self
    {
        $this->equipe_locale = $equipe_locale;

        return $this;
    }

    public function getDomicileExterieur(): ?int
    {
        return $this->domicile_exterieur;
    }

    public function setDomicileExterieur(int $domicile_exterieur): self
    {
        $this->domicile_exterieur = $domicile_exterieur;

        return $this;
    }

    public function getEquipeAdverse(): ?string
    {
        return $this->equipe_adverse;
    }

    public function setEquipeAdverse(string $equipe_adverse): self
    {
        $this->equipe_adverse = $equipe_adverse;

        return $this;
    }

    public function getHote(): ?string
    {
        return $this->hote;
    }

    public function setHote(string $hote): self
    {
        $this->hote = $hote;

        return $this;
    }

    public function getDateHeure(): ?DateTimeInterface
    {
        return $this->date_heure;
    }

    public function setDateHeure(DateTimeInterface $date_heure): self
    {
        $this->date_heure = $date_heure;
        return $this;
    }

    public function getNumSemaine(): ?int
    {
        return $this->num_semaine;
    }

    public function setNumSemaine(int $num_semaine): self
    {
        $this->num_semaine = $num_semaine;

        return $this;
    }

    public function getNumJournee(): ?int
    {
        return $this->num_journee;
    }

    public function setNumJournee(int $num_journee): self
    {
        $this->num_journee = $num_journee;

        return $this;
    }

    public function getGymnase(): ?string
    {
        return $this->gymnase;
    }

    public function setGymnase(string $gymnase): self
    {
        $this->gymnase = $gymnase;

        return $this;
    }
}
