<?php

declare(strict_types=1);

namespace App\core\Domain\Exception;

class InvalidEmailException extends \DomainException
{
    public static function fromEmail(string $email): never
    {
        throw new self(\sprintf('Invalid email %s', $email));
    }
}
