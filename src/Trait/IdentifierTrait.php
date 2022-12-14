<?php

declare(strict_types=1);

namespace App\Trait;

trait IdentifierTrait
{
    protected readonly string $id;

    public function getId(): string
    {
        return $this->id;
    }
}
