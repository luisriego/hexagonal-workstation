<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller\User;

use App\Http\Response\ApiResponse;
use App\Service\User\UpdateUserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateUserAction
{
    public function __construct(private readonly UpdateUserService $updateUserService)
    {
    }

    public function __invoke(Request $request, string $id): ApiResponse
    {
        $responseData = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (null === $name = $responseData['name']) {
            throw new BadRequestHttpException('Name param is mandatory');
        }

        $user = $this->updateUserService->__invoke($id, $name);

        return new ApiResponse($user->toArray());
    }
}
