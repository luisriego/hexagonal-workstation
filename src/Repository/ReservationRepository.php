<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;
    public function remove(Reservation $reservation): void;
    public function findReservationsActives(\DateTime $from, \DateTime $to): Reservation|array|null;
}