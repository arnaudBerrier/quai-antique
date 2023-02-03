<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maxSeats = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOpenMorning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeCloseMorning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOpenEvening = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeCloseEvening = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxSeats(): ?int
    {
        return $this->maxSeats;
    }

    public function setMaxSeats(int $maxSeats): self
    {
        $this->maxSeats = $maxSeats;

        return $this;
    }

    public function getTimeOpenMorning(): ?\DateTimeInterface
    {
        return $this->timeOpenMorning;
    }

    public function setTimeOpenMorning(?\DateTimeInterface $timeOpenMorning): self
    {
        $this->timeOpenMorning = $timeOpenMorning;

        return $this;
    }

    public function getTimeCloseMorning(): ?\DateTimeInterface
    {
        return $this->timeCloseMorning;
    }

    public function setTimeCloseMorning(?\DateTimeInterface $timeCloseMorning): self
    {
        $this->timeCloseMorning = $timeCloseMorning;

        return $this;
    }

    public function getTimeOpenEvening(): ?\DateTimeInterface
    {
        return $this->timeOpenEvening;
    }

    public function setTimeOpenEvening(?\DateTimeInterface $timeOpenEvening): self
    {
        $this->timeOpenEvening = $timeOpenEvening;

        return $this;
    }

    public function getTimeCloseEvening(): ?\DateTimeInterface
    {
        return $this->timeCloseEvening;
    }

    public function setTimeCloseEvening(?\DateTimeInterface $timeCloseEvening): self
    {
        $this->timeCloseEvening = $timeCloseEvening;

        return $this;
    }

}
