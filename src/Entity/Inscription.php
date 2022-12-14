<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{   
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Employe",cascade={"persist"})
     * @ORM\JoinColumn()
     */
    private $employe;

    /**
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumn()
     */
    private $formation;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statut;

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
}
