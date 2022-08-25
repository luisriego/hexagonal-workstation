<?php

namespace App\core\Service\User;

use App\core\Domain\Model\User;
use App\core\Domain\Exception\User\UserAlreadyExistsException;
use App\core\Adapter\Database\ORM\Doctrine\Repository\DoctrineUserRepository;

class CreateUserService
{
    public function __construct(private readonly DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(string $name, string $email): User
    {
        if ($this->userRepository->findOneByEmail($email)) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

//        $user = new User($name, $email);
        $user = User::create($name, $email);

        try {
            $this->userRepository->save($user);
        } catch (\Exception) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

        return $user;
    }
}
