<?php

namespace App\core\Service\User;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use App\Repository\DoctrineUserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetUserByIdService
{
    public function __construct(private readonly DoctrineUserRepository $doctrineUserRepository)
    {
    }

    public function __invoke(string $id): User
    {
        if (null === $user = $this->doctrineUserRepository->findOneById($id)) {
            throw UserNotFoundException::fromId($id);
//            throw new NotFoundHttpException(sprintf('User with id %s not found', $id));
        }

        return $user;
    }
}
