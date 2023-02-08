<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nb_covers = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Planning $planning = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Schedule $hours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbCovers(): ?int
    {
        return $this->nb_covers;
    }

    public function setNbCovers(int $nb_covers): self
    {
        $this->nb_covers = $nb_covers;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHours(): ?Schedule
    {
        return $this->hours;
    }

    public function setHours(?Schedule $hours): self
    {
        $this->hours = $hours;

        return $this;
    }
}
