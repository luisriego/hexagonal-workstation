<?php

declare(strict_types=1);

namespace App\core\Application\UseCase\User\DeleteUser\DTO;

use App\core\Domain\Exception\InvalidArgumentException;

class DeleteUserInputDTO
{
    private function __construct(
        public readonly string $id
    ) {
    }

    public static function create(?string $id): self
    {
        if (\is_null($id)) {
            throw InvalidArgumentException::createFromMessage('User ID can\'t be null');
        }

        return new static($id);
    }
}