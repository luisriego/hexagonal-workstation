<?php

declare(strict_types=1);

namespace App\Service\Workstation;

use App\Entity\User;
use App\Exception\Workstation\WorkstationNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineWorkstationRepository;

class RemoveWorkstationService
{
    public function __construct(private DoctrineWorkstationRepository $WorkstationRepository)
    {
    }

    public function __invoke(string $id, User $user): void
    {
        if (null === $Workstation = $this->WorkstationRepository->findOneByIdIfActive($id)) {
            throw WorkstationNotFoundException::fromId($id);
        }

        if (!$Workstation->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $this->WorkstationRepository->remove($Workstation);
    }
}
