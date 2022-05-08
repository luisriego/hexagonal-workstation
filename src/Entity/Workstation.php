<?php

declare(strict_types=1);

namespace App\Entity;

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


    public function __construct(private string $number, private string $floor)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->isActive = false;
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
}
