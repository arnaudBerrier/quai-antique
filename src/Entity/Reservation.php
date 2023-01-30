<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $number_seat = null;

    #[ORM\Column(length:255, nullable:true)]
    private ?string $allergy = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $r_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $h_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;

    public function __construct()
    {
        $this->created_At = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

 

    public function getNumberSeat(): ?int
    {
        return $this->number_seat;
    }

    public function setNumberSeat(int $number_seat): self
    {
        $this->number_seat = $number_seat;

        return $this;
    }

    public function getRDate(): ?\DateTimeInterface
    {
        return $this->r_date;
    }

    public function setRDate(\DateTimeInterface $r_date): self
    {
        $this->r_date = $r_date;

        return $this;
    }

    public function getHDate(): ?\DateTimeInterface
    {
        return $this->h_date;
    }

    public function setHDate(\DateTimeInterface $h_date): self
    {
        $this->h_date = $h_date;

        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->allergy;
    }

    public function setAllergy(string $allergy): self
    {
        $this->allergy = $allergy;

        return $this;
    }
 

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $created_At): self
    {
        $this->created_At = $created_At;

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
}
