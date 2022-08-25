<?php

namespace App\core\Service\User;

use App\core\Domain\Model\User;
//use App\core\Domain\Exception\User\UserNotFoundException;
use App\core\Adapter\Database\ORM\Doctrine\Repository\DoctrineUserRepository;

class ActivateUserService
{
    public function __construct(private readonly DoctrineUserRepository $userRepository, private readonly EncodePasswordService $encodePassword)
    {
    }

    public function __invoke(string $email, string $token, string $password): User
    {
//        if (null === $user = $this->userRepository->findOneByEmailAndToken($email, $token)) {
//            throw new UserNotFoundException("This User can't be Activate because not exist yet");
//        }
        $user = $this->userRepository->findOneInactiveByEmailAndTokenOrFail($email, $token);
        $user->setPassword($this->encodePassword->generateEncodedPassword($user, $password));
        $user->toggleActive();
        $user->setToken(null);
        $this->userRepository->save($user);

        return $user;
    }
}
