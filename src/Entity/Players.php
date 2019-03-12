<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayersRepository")
 */
class Players
{
    const STATUS_ACTIVE = 100;
    const STATUS_DELETED = -100;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUri;

    /**
     * @ORM\Column(type="smallint")
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players")
     */
    private $team;

    public function __construct()
    {
        if(!$this->created_dt) {
            $this->created_dt = new \DateTime('now');
        }
        $this->updated_dt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getImageUri(): ?string
    {
        return $this->imageUri;
    }

    public function setImageUri(string $imageUri): self
    {
        $this->imageUri = $imageUri;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
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

    public function getTeamId(): ?Team
    {
        return $this->team;
    }

    public function setTeamId(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
