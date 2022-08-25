<?php

declare(strict_types=1);

namespace App\core\Service\User;

use App\Exception\User\UserNotFoundException;
use App\Repository\DoctrineUserRepository;

class DeleteUserService
{
    public function __construct(private readonly DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(string $id): void
    {
        if (null === $user = $this->userRepository->findOneByIdOrFail($id)) {
            throw UserNotFoundException::fromId($id);
        }

        $this->userRepository->remove($user);
    }
}
