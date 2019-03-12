<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoUri;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Players", mappedBy="team")
     */
    private $players;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_dt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_dt;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        if(!$this->created_dt) {
            $this->created_dt = new \DateTime('now');
        }
        $this->updated_dt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogoUri(): ?string
    {
        return $this->logoUri;
    }

    public function setLogoUri(string $logoUri): self
    {
        $this->logoUri = $logoUri;

        return $this;
    }

    /**
     * @return Collection|Players[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Players $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeamId($this);
        }

        return $this;
    }

    public function removePlayer(Players $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeamId() === $this) {
                $player->setTeamId(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedDt(): ?\DateTimeInterface
    {
        return $this->created_dt;
    }

    public function setCreatedDt(\DateTimeInterface $created_dt): self
    {
        $this->created_dt = $created_dt;

        return $this;
    }

    public function getUpdatedDt(): ?\DateTimeInterface
    {
        return $this->updated_dt;
    }

    public function setUpdatedDt(\DateTimeInterface $updated_dt): self
    {
        $this->updated_dt = $updated_dt;

        return $this;
    }
}
