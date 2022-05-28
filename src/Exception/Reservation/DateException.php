<?php

declare(strict_types=1);

namespace App\Exception\Reservation;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DateException extends BadRequestHttpException
{
    public static function EndDateBeforeStartDate(): never
    {
        throw new self('Start date must be before the end date');
    }

    public static function StartDateBeforeToday(): never
    {
        throw new self('Start date must be a future date');
    }

    public static function DateUnavailable(): never
    {
        throw new self('These dates are not available for this workstation');
    }
}
