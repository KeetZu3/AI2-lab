<?php

namespace App\Entity;

use App\Repository\MiejscowoscRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MiejscowoscRepository::class)]
class Miejscowosc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nazwa = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    #[ORM\OneToMany(targetEntity: DaneMeteorologiczne::class, mappedBy: 'location')]
    private Collection $daneMeteorologicznes;

    public function __construct()
    {
        $this->daneMeteorologicznes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): static
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Collection<int, DaneMeteorologiczne>
     */
    public function getDaneMeteorologicznes(): Collection
    {
        return $this->daneMeteorologicznes;
    }

    public function addDaneMeteorologiczne(DaneMeteorologiczne $daneMeteorologiczne): static
    {
        if (!$this->daneMeteorologicznes->contains($daneMeteorologiczne)) {
            $this->daneMeteorologicznes->add($daneMeteorologiczne);
            $daneMeteorologiczne->setLocation($this);
        }

        return $this;
    }

    public function removeDaneMeteorologiczne(DaneMeteorologiczne $daneMeteorologiczne): static
    {
        if ($this->daneMeteorologicznes->removeElement($daneMeteorologiczne)) {
            // set the owning side to null (unless already changed)
            if ($daneMeteorologiczne->getLocation() === $this) {
                $daneMeteorologiczne->setLocation(null);
            }
        }

        return $this;
    }
    // Dodajemy metodę __toString()
    public function __toString(): string
    {
        return $this->nazwa; // Zwracamy nazwę miejscowości jako string
    }
}
