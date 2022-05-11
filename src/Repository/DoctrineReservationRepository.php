<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;

class DoctrineReservationRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Reservation::class;
    }


    public function findAllActives(): array
    {
        return $this->objectRepository->findBy([]);
    }

    public function findOneById(string $id): ?Reservation
    {
        return $this->objectRepository->findOneBy(['id' => $id]);
    }

    public function findOneByIdIfActive(string $id): ?Reservation
    {
        return $this->objectRepository->findOneBy(['id' => $id, 'isActive' => true]);
    }

    public function findOneByNumber(string $number): ?Reservation
    {
        return $this->objectRepository->findOneBy(['number' => $number]);
    }

    public function findOneByNumberIfActive(string $number): ?Reservation
    {
        return $this->objectRepository->findOneBy(['number' => $number, 'isActive' => true]);
    }

    public function save(Reservation $reservation): void
    {
        $this->saveEntity($reservation);
    }

    public function remove(Reservation $reservation): void
    {
        $this->removeEntity($reservation);
    }
}
