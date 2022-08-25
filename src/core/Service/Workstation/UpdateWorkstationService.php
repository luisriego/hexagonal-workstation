<?php

declare(strict_types=1);

namespace App\core\Service\Workstation;

use App\core\Domain\Model\Workstation;
use App\core\Domain\Exception\Workstation\WorkstationNotFoundException;
use App\core\Adapter\Database\ORM\Doctrine\Repository\DoctrineWorkstationRepository;

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
