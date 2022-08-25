<?php

namespace App\core\Domain\Model;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class Reservation
{
    use IdentifierTrait;
    use IsActiveTrait;
    use TimestampableTrait;

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
    private UserInterface $user;

    public function __construct(DateTime $startDate, DateTime $endDate, Workstation $workstation, UserInterface $user)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->isActive = 0;
        $this->workstation = $workstation;
        $this->user = $user;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function getWorkstation(): Workstation
    {
        return $this->workstation;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    #[ArrayShape(['id' => 'string', 'startDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'endDate' => "\_PHPStan_7bd9fb728\Nette\Utils\DateTime", 'notes' => 'null|string', 'workstation' => "\App\Entity\Workstation", 'user' => "\App\Entity\User"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'notes' => $this->notes,
            'workstation' => $this->workstation->getId(),
            'user' => $this->user->getid(),
        ];
    }

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
