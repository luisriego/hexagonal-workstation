<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Workstation;

class DoctrineWorkstationRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Workstation::class;
    }

    public function findOneById(string $id): ?Workstation
    {
        return $this->objectRepository->findOneBy(['id' => $id]);
    }

    public function findOneByIdIfActive(string $id): ?Workstation
    {
        return $this->objectRepository->findOneBy(['id' => $id, 'isActive' => true]);
    }

    public function findOneByNumber(string $number): ?Workstation
    {
        return $this->objectRepository->findOneBy(['number' => $number]);
    }

    public function findOneByNumberIfActive(string $number): ?Workstation
    {
        return $this->objectRepository->findOneBy(['number' => $number, 'isActive' => true]);
    }

    public function findOneByNumberAndIsActive(string $number): ?Workstation
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM App\Entity\Workstation c WHERE (c.number = :number AND c.isActive = true)'
        );
        $query->setParameter('number', $number);

        return $query->getOneOrNullResult();
    }

    public function save(Workstation $workstation): void
    {
        $this->saveEntity($workstation);
    }

    public function remove(Workstation $workstation): void
    {
        $this->removeEntity($workstation);
    }
}
