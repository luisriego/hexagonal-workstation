<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Repository\DoctrineUserRepository;

class GetUsersAction
{
    public function __construct(private readonly DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(): ApiResponse
    {
        $users = $this->userRepository->all();

        $result = array_map(fn(User $user): array => $user->toArray(), $users);

        return new ApiResponse(['users' => $result]);
    }
}
