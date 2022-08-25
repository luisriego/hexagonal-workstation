<?php

declare(strict_types=1);

namespace App\core\Service\User;

use App\core\Domain\Model\User;
use App\core\Domain\Exception\Password\PasswordException;
use App\Repository\DoctrineUserRepository;

class ChangePasswordService
{
    public function __construct(private readonly DoctrineUserRepository $userRepository, private readonly EncodePasswordService $encodePasswordService)
    {
    }

    public function __invoke(string $oldPass, string $newPass, User $user): User
    {
        if (!$this->encodePasswordService->isValidPassword($user, $oldPass)) {
            throw PasswordException::oldPasswordDoesNotMatch();
        }

        $user->setPassword($this->encodePasswordService->generateEncodedPassword($user, $newPass));

        $this->userRepository->save($user);

        return $user;
    }
}
