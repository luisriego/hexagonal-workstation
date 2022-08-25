<?php

declare(strict_types=1);

namespace App\core\Domain\Validation\Traits;

use App\core\Domain\Exception\InvalidArgumentException;

trait AssertMinimumAgeTrait
{
    public function assertMinimumAge(int $age, int $minimumAge): void
    {
        if ($minimumAge > $age) {
            throw InvalidArgumentException::createFromMessage(\sprintf('Age has to be at least %d', $minimumAge));
        }
    }
}
