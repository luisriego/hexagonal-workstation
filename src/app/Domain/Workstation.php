<?php

declare(strict_types=1);

namespace App\app\Domain;

use App\Entity\Reservation;
use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

class Workstation
{
    use IdentifierTrait;
    use IsActiveTrait;
    use TimestampableTrait;

    private ?string $map = null;

    private $reservations;

    public function __construct(private string $number, private string $floor)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->isActive = false;
        $this->reservations = new ArrayCollection();
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getFloor(): string
    {
        return $this->floor;
    }

    public function setFloor(string $floor): void
    {
        $this->floor = $floor;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(?string $map): void
    {
        $this->map = $map;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setWorstation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getWorstation() === $this) {
                $reservation->setWorstation(null);
            }
        }

        return $this;
    }

    #[ArrayShape(['id' => 'string', 'floor' => 'string', 'number' => 'string', 'map' => 'null|string'])]
    public function toArraySimple(): array
    {
        return [
            'id' => $this->id,
            'floor' => $this->floor,
            'number' => $this->number,
            'map' => $this->map,
        ];
    }

    #[ArrayShape(['id' => 'string', 'floor' => 'string', 'number' => 'string', 'map' => 'null|string', 'active' => 'false', 'createdOn' => 'string', 'updatedOn' => 'string'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'floor' => $this->floor,
            'number' => $this->number,
            'map' => $this->map,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

    #[ArrayShape(['id' => 'string', 'floor' => 'string', 'number' => 'string', 'map' => 'null|string', 'reservation' => "\Doctrine\Common\Collections\ArrayCollection", 'active' => 'false', 'createdOn' => 'string', 'updatedOn' => 'string'])]
    public function toArrayComplete(): array
    {
        return [
            'id' => $this->id,
            'floor' => $this->floor,
            'number' => $this->number,
            'map' => $this->map,
            'reservation' => $this->reservations,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }
}
