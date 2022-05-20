<?php

declare(strict_types=1);

namespace App\Customer\Repository;

use App\Entity\Reservation;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;
}
