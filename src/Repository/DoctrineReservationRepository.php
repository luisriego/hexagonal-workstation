<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Workstation;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

class DoctrineReservationRepository extends DoctrineBaseRepository implements ReservationRepository
{
    protected static function entityClass(): string
    {
        return Reservation::class;
    }

    public function findAllActivesBetween(DateTime $from, DateTime $to): Reservation|array|null
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
        return $qb->getQuery()->getResult();
    }

    public function save(Reservation $reservation): void
    {
        $this->saveEntity($reservation);
    }

    public function remove(Reservation $reservation): void
    {
        $this->removeEntity($reservation);
    }



//
//    public function findAllActives(): array
//    {
//        return $this->objectRepository->findBy(['isActive' => true], ['workstation' => 'ASC']);
//    }
//
//    public function findOneReservationWithQueryBuilder(\DateTime $from, \DateTime $to): ?int
//    {
//        $qb = $this->objectRepository->createQueryBuilder('r');
//        $query = $qb->andWhere(
//            $qb->expr()->gte('r.startDate', ':from'),
//            $qb->expr()->lt('r.endDate', ':to'),
//        );
//
//        $qb->setParameter('from', $from);
//        $qb->setParameter('to', $to);
//
//        return $query->getFirstResult();
//    }


    public function findReservationsUsedYet(DateTime $from, DateTime $to): ?array
    {
        $subQueryBuilder = $this->objectRepository->createQueryBuilder('r');
            $sq = $subQueryBuilder
                ->select('ws.id')
                ->distinct()
                ->from('App:Reservation', 'reservation')
                ->orWhere('reservation.startDate BETWEEN :from AND :to')
                ->orWhere('reservation.endDate BETWEEN :from AND :to')
                ->orWhere('reservation.startDate <= :from AND reservation.endDate >= :to')
                ->innerJoin('reservation.workstation', 'ws')
                ->setParameter('from', $from )
                ->setParameter('to', $to)
                ->getQuery()
            ;

        return $sq->getResult();
    }

    public function userHasRequestThisReservationYet(DateTime $from, DateTime $to, string $user): bool
    {
        $subQueryBuilder = $this->objectRepository->createQueryBuilder('r');
        $sq = $subQueryBuilder
            ->orWhere('r.startDate BETWEEN :from AND :to')
            ->orWhere('r.endDate BETWEEN :from AND :to')
            ->orWhere('r.startDate <= :from AND r.endDate >= :to')
            ->andWhere('r.user = :user')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('user', $user)
            ->getQuery()
        ;

        $results = count($sq->getResult());

        if ($results !== 0) {
            return true;
        }

        return false;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findReservationWithWorkstation(DateTime $from, DateTime $to, string $workstation): ?Reservation
    {
        $subQueryBuilder = $this->objectRepository->createQueryBuilder('r');
        $sq = $subQueryBuilder
            ->orWhere('r.startDate BETWEEN :from AND :to')
            ->orWhere('r.endDate BETWEEN :from AND :to')
            ->orWhere('r.startDate <= :from AND r.endDate >= :to')
            ->andWhere('r.workstation = :workstation')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('workstation', $workstation)
            ->getQuery()
        ;

        $result = $sq->getOneOrNullResult();

        return $result;
    }
}
