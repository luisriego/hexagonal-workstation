<?php

declare(strict_types=1);

namespace App\Service\Workstation;

use App\Entity\Workstation;
use App\Entity\User;
use App\Exception\Workstation\WorkstationNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineWorkstationRepository;

class GetWorkstationByIdService
{
    public function __construct(private readonly DoctrineWorkstationRepository $WorkstationRepository)
    {
    }

    public function __invoke(string $id): Workstation
    {
        if (null === $Workstation = $this->WorkstationRepository->findOneByIdIfActive($id)) {
            throw WorkstationNotFoundException::fromId($id);
        }

        return $Workstation;
    }
}