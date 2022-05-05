<?php

declare(strict_types=1);

namespace App\Exception\Workstation;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkstationNotFoundException extends NotFoundHttpException
{
    public static function fromNumber(string $number): self
    {
        throw new self(\sprintf('Workstation with Number %s not found', $number));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('Condo with ID %s not found', $id));
    }
}
