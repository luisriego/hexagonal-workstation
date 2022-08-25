<?php

declare(strict_types=1);

namespace App\core\Domain\Exception\User;

class UserAlreadyExistsException extends \DomainException
{
    public static function fromEmail(string $email): never
    {
        throw new self(\sprintf('User with email %s already exists', $email));
    }
}
