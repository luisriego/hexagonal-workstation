<?php

declare(strict_types=1);

namespace App\core\Domain\Exception\User;

class UserNotFoundException extends \DomainException
{
    public static function fromEmail(string $email): never
    {
        throw new self(\sprintf('User with email %s not found', $email));
    }

    public static function fromId(string $id): never
    {
        throw new self(\sprintf('User with ID %s not found', $id));
    }

    public static function fromEmailAndToken(string $email, string $token): never
    {
        throw new self(\sprintf('User with email %s and token %s not found', $email, $token));
    }
}
