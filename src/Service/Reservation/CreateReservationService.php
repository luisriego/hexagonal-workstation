<?php

declare(strict_types=1);

namespace App\Service\Reservation;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Workstation;
use App\Exception\Reservation\DateException;
use App\Exception\User\UserHasMadeReservationException;
use App\Repository\DoctrineReservationRepository;
use App\Repository\DoctrineWorkstationRepository;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
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
        /** @var User $user */
        $user = $this->security->getUser();
        $today = new DateTime();
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        if ($startDate < $today) {
            throw DateException::StartDateBeforeToday();
        }

        if ($startDate > $endDate) {
            throw DateException::EndDateBeforeStartDate();
        }

        if (null === $workstation = $this->findFreeWorkstation($startDate, $endDate, $user->getId(), $workstation_id)) {
            throw DateException::DateUnavailable();
        }

        $reservation = new Reservation($startDate, $endDate, $workstation, $user);
        if ('' !== $notes) {
            $reservation->setNotes($notes);
        }
        $this->reservationRepository->save($reservation);

        return $reservation;
    }

    /**
     * @throws NonUniqueResultException
     */
    private function findFreeWorkstation(DateTime $startDate, DateTime $endDate, string $user, string $workstation_id): ?Workstation
    {
        if ($this->reservationRepository->userHasRequestThisReservationYet($startDate, $endDate, $user)) {
            throw UserHasMadeReservationException::yet();
        }

        if ('' === $workstation_id) {
            $reservationsUsedYet = $this->reservationRepository->findReservationsUsedYet($startDate, $endDate);

            if (0 === count($reservationsUsedYet)) {
                return $this->workstationRepository->findOneActive();
            }

            return $this->workstationRepository->notIn($reservationsUsedYet);
        }

        $reservation = $this->reservationRepository->findReservationWithWorkstation($startDate, $endDate, $workstation_id);

        if (null !== $reservation) {
            return null;
        }

        return $this->workstationRepository->findOneByIdIfActive($workstation_id);
    }

    private function findFreeWorkstation2(DateTime $startDate, DateTime $endDate, string $user): ?Workstation
    {
        $wsInRv = [];
        $wsIds = [];
        $reservations = $this->reservationRepository->findAllActivesBetween($startDate, $endDate);

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
