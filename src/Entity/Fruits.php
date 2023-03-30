<?php

namespace App\Entity;

use App\Repository\FruitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitsRepository::class)]
class Fruits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $genus = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $orderBy = null;

    #[ORM\Column]
    private array $nutritions = [];

    #[ORM\Column]
    private ?bool $isFavourite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
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

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getNutritions(): array
    {
        return $this->nutritions;
    }

    public function setNutritions(array $nutritions): self
    {
        $this->nutritions = $nutritions;

        return $this;
    }

    public function getIsFavourite(): ?bool
    {
        return $this->isFavourite;
    }

    public function setIsFavourite(bool $isFavourite): self
    {
        $this->isFavourite = $isFavourite;

        return $this;
    }
}
