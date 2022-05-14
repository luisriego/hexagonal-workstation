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
        $reservations = $this->reservationRepository->findAllActives();
        foreach ($reservations as $reservation) {
            if (!$this->between($startDate, $reservation)) {

            }
//            if ($reservation->getStartDate() <= $startDate & $reservation->getEndDate() >= $startDate) {
//                return null;
//            }
//
//            if ($reservation->getStartDate() <= $endDate & $reservation->getEndDate() >= $endDate) {
//                return null;
//            }
//
//            return $reservation->getWorkstation();
        }
        return null;
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
