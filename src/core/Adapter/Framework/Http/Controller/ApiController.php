<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller;

use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{
    public function createResponse(array $data, int $status = JsonResponse::HTTP_OK): ApiResponse
    {
        return new ApiResponse($data, $status);
    }
}
