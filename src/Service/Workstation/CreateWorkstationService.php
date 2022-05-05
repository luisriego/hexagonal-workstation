<?php

declare(strict_types=1);

namespace App\Service\Workstation;

use App\Entity\Workstation;
use App\Entity\User;
use App\Exception\Workstation\WorkstationAlreadyExistsException;
use App\Repository\DoctrineWorkstationRepository;

class CreateWorkstationService
{
    public function __construct(
        private readonly DoctrineWorkstationRepository $WorkstationRepository
    ) {
    }

    public function __invoke(string $number, string $floor, User $user): Workstation
    {
        if ($this->WorkstationRepository->findOneByNumber($number)) {
            throw new WorkstationAlreadyExistsException(\sprintf('Workstation with Number %s already exists', $number));
        }

        $Workstation = new Workstation($number, $floor);
        $this->WorkstationRepository->save($Workstation);
//        $user->addWorkstation($Workstation);
//        $this->userRepository->save($user);

        return $Workstation;
    }
}
