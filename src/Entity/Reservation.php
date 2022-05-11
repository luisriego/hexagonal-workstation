<?php

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\TimestampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

class Reservation
{
    use IdentifierTrait, TimestampableTrait;

    #[ORM\Column(type: 'datetime', nullable: false) ]
    private DateTime $startDate;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTime $endDate;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = '';

    #[ORM\ManyToOne(targetEntity: Workstation::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workstation $workstation;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function __construct(DateTime $startDate, DateTime $endDate, Workstation $workstation, User $user)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->workstation = $workstation;
        $this->user = $user;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return Workstation
     */
    public function getWorkstation(): Workstation
    {
        return $this->workstation;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


    #[ArrayShape(['id' => "string", 'startDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'endDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'notes' => "null|string", 'workstation' => "\App\Entity\Workstation", 'user' => "\App\Entity\User"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'notes' => $this->notes,
            'workstation' => $this->workstation,
            'user' => $this->user,
        ];
    }

    #[ArrayShape(['id' => "string", 'startDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'endDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'notes' => "null|string", 'workstation' => "\App\Entity\Workstation", 'user' => "\App\Entity\User", 'createdOn' => "string", 'updatedOn' => "string"])]
    public function toArrayComplete(): array
    {
        return [
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'notes' => $this->notes,
            'workstation' => $this->workstation,
            'user' => $this->user,
            'createdOn' => $this->createdOn->format(DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(DateTime::RFC3339),
        ];
    }
}