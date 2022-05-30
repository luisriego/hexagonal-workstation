<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Workstation;

interface WorkstationRepository
{
    public function save(Workstation $workstation): void;

    public function remove(Workstation $workstation): void;

    public function findOneByIdIfActive(string $id): ?Workstation;

    public function findOneActive(): ?Workstation;

    public function notIn(array $workstations): ?Workstation;
}
