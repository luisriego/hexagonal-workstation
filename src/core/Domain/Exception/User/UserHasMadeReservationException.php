<?php

declare(strict_types=1);

namespace App\core\Domain\Exception\User;

class UserHasMadeReservationException extends \DomainException
{
    public static function yet(): never
    {
        throw new self('This User already has a reservation for these dates.');
    }
}
