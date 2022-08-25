<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller\User;

use App\Http\Response\ApiResponse;
use App\Service\User\DeleteUserService;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserAction
{
    public function __construct(private readonly DeleteUserService $deleteUserService)
    {
    }

    public function __invoke(string $id): ApiResponse
    {
        $this->deleteUserService->__invoke($id);

        return new ApiResponse([], Response::HTTP_NO_CONTENT);
    }
}
