<?php

namespace App\Entity;

use App\Repository\DaneMeteorologiczneRepository;
use App\Entity\Miejscowosc;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DaneMeteorologiczneRepository::class)]
class DaneMeteorologiczne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'daneMeteorologicznes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Miejscowosc $location = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $temperatura_w_celsjuszach = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_pomiaru = null;

    #[ORM\Column(nullable: true)]
    private ?int $wilgotnosc = null;

    #[ORM\Column(nullable: true)]
    private ?int $cisnienie = null;

    #[ORM\Column]
    private ?int $wiatr = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Miejscowosc
    {
        return $this->location;
    }

    public function setLocation(?Miejscowosc $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTemperaturaWCelsjuszach(): ?string
    {
        return $this->temperatura_w_celsjuszach;
    }

    public function setTemperaturaWCelsjuszach(string $temperatura_w_celsjuszach): static
    {
        $this->temperatura_w_celsjuszach = $temperatura_w_celsjuszach;

        return $this;
    }

    public function getDataPomiaru(): ?\DateTimeInterface
    {
        return $this->data_pomiaru;
    }

    public function setDataPomiaru(\DateTimeInterface $data_pomiaru): static
    {
        $this->data_pomiaru = $data_pomiaru;

        return $this;
    }

    public function getWilgotnosc(): ?int
    {
        return $this->wilgotnosc;
    }

    public function setWilgotnosc(?int $wilgotnosc): static
    {
        $this->wilgotnosc = $wilgotnosc;

        return $this;
    }

    public function getCisnienie(): ?int
    {
        return $this->cisnienie;
    }

    public function setCisnienie(?int $cisnienie): static
    {
        $this->cisnienie = $cisnienie;

        return $this;
    }

    public function getWiatr(): ?int
    {
        return $this->wiatr;
    }

    public function setWiatr(int $wiatr): static
    {
        $this->wiatr = $wiatr;

        return $this;
    }
}
