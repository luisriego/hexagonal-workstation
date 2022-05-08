<?php

namespace App\Security\Core\User;

use App\Entity\User;
use App\Repository\DoctrineUserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(private readonly DoctrineUserRepository $userRepository)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(\sprintf('Instances of %s are not supported', $user::class));
        }

        return $this->loadUserByIdentifier($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $username): UserInterface
    {
        try {
            return $this->userRepository->findOneByEmailOrFail($username);
        } catch (UserNotFoundException) {
            throw new \Symfony\Component\Security\Core\Exception\UserNotFoundException(\sprintf('User %s not found, $username'));
        }
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method void upgradePassword(PasswordAuthenticatedUserInterface|UserInterface $user, string $newHashedPassword)
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        $user->setPassword($newEncodedPassword);

        $this->userRepository->save($user);
    }

    public function loadUserByUsername(string $username)
    {
        try {
            return $this->userRepository->findOneByEmailOrFail($username);
        } catch (UserNotFoundException) {
            throw new \Symfony\Component\Security\Core\Exception\UserNotFoundException(\sprintf('User %s not found, $username'));
        }
    }
}
