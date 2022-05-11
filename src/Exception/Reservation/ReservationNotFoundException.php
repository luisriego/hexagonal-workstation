<?php

declare(strict_types=1);

namespace App\Exception\Reservation;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationNotFoundException extends NotFoundHttpException
{
    public static function fromId(string $id): never
    {
        throw new self(\sprintf('Reservation with ID %s not found', $id));
    }
}
