<?php

declare(strict_types=1);

namespace App\Exception\Workstation;

class WorkstationAlreadyExistsException extends \DomainException
{
    public static function fromNumber(string $number): self
    {
        throw new self(\sprintf('Workstation with Number %s already exists', $number));
    }
}
