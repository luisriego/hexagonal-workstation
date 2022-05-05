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

    private string $number;
    private string $floor;
    private ?string $map;


    public function __construct(string $number, string $floor)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->number = $number;
        $this->floor = $floor;
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

    #[ArrayShape(['id' => "string", 'floor' => "string", 'number' => "string", 'active' => "false", 'createdOn' => "string", 'updatedOn' => "string"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'floor' => $this->floor,
            'number' => $this->number,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }
}
