<?php

declare(strict_types=1);

namespace App\core\Application\UseCase\User\CreateUser\DTO;

use App\core\Domain\Model\User;
use App\core\Domain\Validation\Traits\AssertLengthRangeTrait;
use App\core\Domain\Validation\Traits\AssertNotNullTrait;

class CreateUserOutputDTO
{
    use AssertNotNullTrait;
    use AssertLengthRangeTrait;

    private const ARGS = [
        'name',
        'email',
    ];

    private function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
    ) {
        $this->assertNotNull(self::ARGS, [$this->name, $this->email]);

        if (!\is_null($this->name)) {
            $this->assertValueRangeLength($this->name, User::NAME_MIN_LENGTH, User::NAME_MAX_LENGTH);
        }
    }

    public static function create(?string $name, ?string $email): self
    {
        return new static($name, $email);
    }
}
