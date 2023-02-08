<?php

namespace App\Entity;

use App\Repository\NbReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NbReservationRepository::class)]
class NbReservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Nb_reservation = null;

    #[ORM\ManyToOne(inversedBy: 'nbReservations')]
    private ?Schedule $schedule = null;

    #[ORM\ManyToOne(inversedBy: 'nbReservations')]
    private ?Planning $nb_reservations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbReservation(): ?int
    {
        return $this->Nb_reservation;
    }

    public function setNbReservation(int $Nb_reservation): self
    {
        $this->Nb_reservation = $Nb_reservation;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getNbReservations(): ?Planning
    {
        return $this->nb_reservations;
    }

    public function setNbReservations(?Planning $nb_reservations): self
    {
        $this->nb_reservations = $nb_reservations;

        return $this;
    }
}
