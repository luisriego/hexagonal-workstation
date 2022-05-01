<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Condo;

class DoctrineCondoRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Condo::class;
    }

    public function findOneByIdIfActive(string $id): ?Condo
    {
        return $this->objectRepository->findOneBy(['id' => $id, 'isActive' => true]);
    }

    public function findOneByCnpj(string $cnpj): ?Condo
    {
        return $this->objectRepository->findOneBy(['cnpj' => $cnpj]);
    }

    public function findOneByCnpjAndIsActive(string $cnpj): ?Condo
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM App\Entity\Condo c WHERE (c.cnpj = :cnpj AND c.isActive = true)'
        );
        $query->setParameter('cnpj', $cnpj);

        return $query->getOneOrNullResult();
    }

    public function save(Condo $condo): void
    {
        $this->saveEntity($condo);
    }

    public function remove(Condo $condo): void
    {
        $this->removeEntity($condo);
    }
}
