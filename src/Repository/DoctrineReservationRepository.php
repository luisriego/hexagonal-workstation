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
        return $this->objectRepository->findBy(['isActive' => true], ['workstation' => 'ASC']);
    }

    public function findOneReservationWithQueryBuilder(\DateTime $from, \DateTime $to): ?int
    {
        $qb = $this->objectRepository->createQueryBuilder('r');
        $query = $qb->andWhere(
            $qb->expr()->gte('c.updated', ':updateDateTimeStart'),
            $qb->expr()->lt('c.updated', ':updateDateTimeEnd'),
        );

        $qb->setParameter('updateDateTimeStart', $from);
        $qb->setParameter('updateDateTimeEnd', $to);

        return $query->getFirstResult();
    }

    public function findOneReservationAndIsActive(\DateTime $from, \DateTime $to): ?Reservation
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT r FROM App\Entity\Reservation r WHERE (e.fecha BETWEEN :from AND :to)'
        );
        $query->setParameters(['from' => $from, 'to' => $to]);

        return $query->getOneOrNullResult();
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
