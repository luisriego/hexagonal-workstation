<?php

declare(strict_types=1);

namespace App\Service\Reservation;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Workstation;
use App\Exception\Reservation\DateException;
use App\Exception\Reservation\ReservationNotFoundException;
use App\Repository\DoctrineReservationRepository;
use App\Repository\DoctrineWorkstationRepository;
use Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CreateReservationService
{
    public function __construct(
        private readonly DoctrineReservationRepository $reservationRepository,
        private readonly DoctrineWorkstationRepository $workstationRepository,
        private readonly Security $security
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(string $start, string $end, string $workstation_id = '', string $notes = ''): Reservation
    {
        /** @var User|UserInterface $user */
        $user = $this->security->getUser();

        $today = new \DateTime();
        $startDate = new \DateTime($start);
        $endDate = new \DateTime($end);

        if ($startDate < $today) {
            throw DateException::StartDateBeforeToday();
        }

        if ($startDate > $endDate) {
            throw DateException::EndDateBeforeStartDate();
        }

        if ($workstation_id === '') {
//            $workstation = $this->workstationRepository->findOneByNumber('default');
            if (null === $workstation = $this->findFreeWorkstation($startDate, $endDate)) {
                throw DateException::DateUnavailable();
            }
        } elseif (null === $workstation = $this->workstationRepository->findOneById($workstation_id)) {
            throw ReservationNotFoundException::fromId($workstation_id);
        }

        $reservation = new Reservation($startDate, $endDate, $workstation, $user);
        if ($notes !== '') {
            $reservation->setNotes($notes);
        }
        $this->reservationRepository->save($reservation);

        return $reservation;
    }

    private function findFreeWorkstation(\DateTime $startDate, \DateTime $endDate): ?Workstation
    {
        $wsInRv = [];
        $wsIds = [];
        $reservations = $this->reservationRepository->findOneReservationAndIsActive($startDate, $endDate);
        $workstations = $this->workstationRepository->findAllActives();
        foreach ($reservations as $reservation) {
            $wsInRv[] = $reservation->getWorkstation()->getId();
        }
        foreach ($workstations as $workstation) {
            $wsIds[] = $workstation->getId();
        }
        $freeWs = array_udiff($wsIds, $wsInRv,
            function ($obj_a, $obj_b) {
                if ($obj_a === $obj_b) {
                    return 0;
                } else {
                    return -1;
                }
            }
        );
        return $this->workstationRepository->findOneById($freeWs[0]);
    }

    private function between(\DateTime $date, Reservation $reservation): bool
    {
        if ($date < $reservation->getStartDate()) {
            return false;
        }

        if ($date > $reservation->getEndDate()) {
            return false;
        }

        return true;
    }
}
