<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $startDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $creator = null;

    #[ORM\Column(nullable: true)]
    private ?int $member = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $musicalStyle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    public function setStartDate(int $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    public function setEndDate(?int $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(?string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getMember(): ?int
    {
        return $this->member;
    }

    public function setMember(?int $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function getMusicalStyle(): ?string
    {
        return $this->musicalStyle;
    }

    public function setMusicalStyle(?string $musicalStyle): static
    {
        $this->musicalStyle = $musicalStyle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}