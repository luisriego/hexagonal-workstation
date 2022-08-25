<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckController
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
