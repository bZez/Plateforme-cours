<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExoSQLRepository")
 */
class ExoSQL
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $objectif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rappel;

    /**
     * @ORM\Column(type="text")
     */
    private $resultat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getRappel(): ?string
    {
        return $this->rappel;
    }

    public function setRappel(?string $rappel): self
    {
        $this->rappel = $rappel;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }
}
