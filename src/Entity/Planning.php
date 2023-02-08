<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $nb_covers = null;

    #[ORM\Column(length: 255)]
    private ?string $startTime = null;

    #[ORM\Column(length: 255)]
    private ?string $endTime = null;

    #[ORM\ManyToOne(inversedBy: 'plannings')]
    private ?Restaurant $restaurant = null;

    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: RefService::class)]
    private Collection $service;

    #[ORM\OneToMany(mappedBy: 'nb_reservations', targetEntity: NbReservation::class)]
    private Collection $nbReservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->nbReservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

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
            $reservation->setPlanning($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getPlanning() === $this) {
                $reservation->setPlanning(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RefService>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(RefService $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
            $service->setPlanning($this);
        }

        return $this;
    }

    public function removeService(RefService $service): self
    {
        if ($this->service->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getPlanning() === $this) {
                $service->setPlanning(null);
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
            $nbReservation->setNbReservations($this);
        }

        return $this;
    }

    public function removeNbReservation(NbReservation $nbReservation): self
    {
        if ($this->nbReservations->removeElement($nbReservation)) {
            // set the owning side to null (unless already changed)
            if ($nbReservation->getNbReservations() === $this) {
                $nbReservation->setNbReservations(null);
            }
        }

        return $this;
    }
}
