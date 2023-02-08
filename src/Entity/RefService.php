<?php

namespace App\Entity;

use App\Repository\RefServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefServiceRepository::class)]
class RefService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $morning = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evening = null;

    #[ORM\ManyToOne(inversedBy: 'service')]
    private ?Planning $planning = null;

    #[ORM\ManyToOne(inversedBy: 'refServices')]
    private ?Schedule $hours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMorning(): ?string
    {
        return $this->morning;
    }

    public function setMorning(?string $morning): self
    {
        $this->morning = $morning;

        return $this;
    }

    public function getEvening(): ?string
    {
        return $this->evening;
    }

    public function setEvening(?string $evening): self
    {
        $this->evening = $evening;

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
