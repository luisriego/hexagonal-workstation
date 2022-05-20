<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\ORM\NonUniqueResultException;

class DoctrineReservationRepository extends DoctrineBaseRepository implements ReservationRepository
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
            $qb->expr()->gte('r.startDate', ':from'),
            $qb->expr()->lt('r.endDate', ':to'),
        );

        $qb->setParameter('from', $from);
        $qb->setParameter('to', $to);

        return $query->getFirstResult();
    }


    public function findOneReservationAndIsActive(\DateTime $from, \DateTime $to): Reservation|array|null
    {
        $qb = $this->objectRepository->createQueryBuilder("r");
        $qb
            ->andWhere('r.startDate < :from')
            ->andWhere('r.startDate < :to')
            ->andWhere('r.endDate > :from')
            ->andWhere('r.endDate > :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
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
