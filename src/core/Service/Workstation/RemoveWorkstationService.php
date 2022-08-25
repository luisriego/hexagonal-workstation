<?php

declare(strict_types=1);

namespace App\core\Service\Workstation;

use App\core\Domain\Model\User;
use App\core\Domain\Exception\Workstation\WorkstationNotFoundException;
use App\core\Adapter\Database\ORM\Doctrine\Repository\DoctrineWorkstationRepository;

class RemoveWorkstationService
{
    public function __construct(private readonly DoctrineWorkstationRepository $WorkstationRepository)
    {
    }

    public function __invoke(string $id, User $user): void
    {
        if (null === $Workstation = $this->WorkstationRepository->findOneByIdIfActive($id)) {
            throw WorkstationNotFoundException::fromId($id);
        }

        $this->WorkstationRepository->remove($Workstation);
    }
}
