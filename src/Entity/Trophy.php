<?php

namespace App\Entity;

use App\Student\Theme;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrophyRepository")
 * @ORM\Table(name="Trophy")
 */
class Trophy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="trophies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sutdent;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $theme;

    /**
     * @ORM\Column(type="datetime")
     */
    private $winAt;

    public function __construct()
    {
        $this->winAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSutdent(): ?Student
    {
        return $this->sutdent;
    }

    public function setSutdent(?Student $sutdent): self
    {
        $this->sutdent = $sutdent;

        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function getWinAt(): ?\DateTimeInterface
    {
        return $this->winAt;
    }

    public function setWinAt(\DateTimeInterface $winAt): self
    {
        $this->winAt = $winAt;

        return $this;
    }
}
