<?php

declare(strict_types=1);

namespace App\Service\Reservation;

use App\Entity\Reservation;
use App\Entity\Workstation;
use App\Exception\Reservation\DateException;
use App\Exception\Reservation\ReservationNotFoundException;
use App\Repository\DoctrineReservationRepository;
use App\Repository\DoctrineWorkstationRepository;
use DateTime;
use Exception;
use Symfony\Component\Security\Core\Security;

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
        $today = new DateTime();
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        if ($startDate < $today) {
            throw DateException::StartDateBeforeToday();
        }

        if ($startDate > $endDate) {
            throw DateException::EndDateBeforeStartDate();
        }

        if ($workstation_id === '') {
            if (null === $workstation = $this->findFreeWorkstation($startDate, $endDate)) {
                throw DateException::DateUnavailable();
            }
        } elseif (null === $workstation = $this->workstationRepository->findOneById($workstation_id)) {
            throw ReservationNotFoundException::fromId($workstation_id);
        }

        $reservation = new Reservation($startDate, $endDate, $workstation, $this->security->getUser());
        if ($notes !== '') {
            $reservation->setNotes($notes);
        }
        $this->reservationRepository->save($reservation);

        return $reservation;
    }

    private function findFreeWorkstation(DateTime $startDate, DateTime $endDate): ?Workstation
    {
        $wsInRv = [];
        $wsIds = [];
        $reservations = $this->reservationRepository->findReservationsActives($startDate, $endDate);
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
        return $this->workstationRepository->findOneByIdIfActive($freeWs[0]);
    }
}
