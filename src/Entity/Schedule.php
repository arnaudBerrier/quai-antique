<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $hour = null;

    #[ORM\OneToMany(mappedBy: 'hours', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'schedule', targetEntity: NbReservation::class)]
    private Collection $nbReservations;

    #[ORM\OneToMany(mappedBy: 'hours', targetEntity: RefService::class)]
    private Collection $refServices;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->nbReservations = new ArrayCollection();
        $this->refServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHour(): ?string
    {
        return $this->hour;
    }

    public function setHour(string $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setHours($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHours() === $this) {
                $reservation->setHours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NbReservation>
     */
    public function getNbReservations(): Collection
    {
        return $this->nbReservations;
    }

    public function addNbReservation(NbReservation $nbReservation): self
    {
        if (!$this->nbReservations->contains($nbReservation)) {
            $this->nbReservations->add($nbReservation);
            $nbReservation->setSchedule($this);
        }

        return $this;
    }

    public function removeNbReservation(NbReservation $nbReservation): self
    {
        if ($this->nbReservations->removeElement($nbReservation)) {
            // set the owning side to null (unless already changed)
            if ($nbReservation->getSchedule() === $this) {
                $nbReservation->setSchedule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RefService>
     */
    public function getRefServices(): Collection
    {
        return $this->refServices;
    }

    public function addRefService(RefService $refService): self
    {
        if (!$this->refServices->contains($refService)) {
            $this->refServices->add($refService);
            $refService->setHours($this);
        }

        return $this;
    }

    public function removeRefService(RefService $refService): self
    {
        if ($this->refServices->removeElement($refService)) {
            // set the owning side to null (unless already changed)
            if ($refService->getHours() === $this) {
                $refService->setHours(null);
            }
        }

        return $this;
    }
}
