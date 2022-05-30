<?php

declare(strict_types=1);

namespace App\Service\Workstation;

use App\Entity\Workstation;
use App\Exception\Workstation\WorkstationNotFoundException;
use App\Repository\DoctrineWorkstationRepository;

class UpdateWorkstationService
{
    public function __construct(private readonly DoctrineWorkstationRepository $workstationRepository)
    {
    }

    public function __invoke(string $map, string $id): Workstation
    {
        if (null === $workstation = $this->workstationRepository->findOneByIdIfActive($id)) {
            throw WorkstationNotFoundException::fromId($id);
        }

        if ($map) {
            $workstation->setMap($map);
            $this->workstationRepository->save($workstation);
        }

        return $workstation;
    }
}
