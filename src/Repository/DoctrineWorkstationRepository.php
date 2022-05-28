<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Workstation;
use App\Exception\Workstation\WorkstationNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

class DoctrineWorkstationRepository extends DoctrineBaseRepository implements WorkstationRepository
{
    protected static function entityClass(): string
    {
        return Workstation::class;
    }

    public function findAllActives(): ?array
    {
        return $this->objectRepository->findBy(['isActive' => 1]);
    }

    public function findOneActive(): ?Workstation
    {
        return $this->objectRepository->findOneBy(['isActive' => 1]);
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

    public function notIn(array $workstations): ?Workstation
    {
        $query = $this->getEntityManager()->createQuery("SELECT w FROM App\Entity\Workstation w WHERE w.id NOT IN (:ws)")
            ->setParameter('ws', $workstations)
            ->getResult()
        ;

        if (count($query) === 0) {
            return null;
        }

        return $query[0];
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
