<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;
use DateTime;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;
    public function remove(Reservation $reservation): void;
    public function findAllActivesBetween(DateTime $from, DateTime $to): Reservation|array|null;
    public function findReservationsUsedYet(DateTime $from, DateTime $to): ?array;
    public function userHasRequestThisReservationYet(DateTime $from, DateTime $to, string $user): bool;
    public function findReservationWithWorkstation(DateTime $from, DateTime $to, string $workstation): ?Reservation;
}
