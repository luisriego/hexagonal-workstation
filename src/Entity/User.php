<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface
{
    use IdentifierTrait;
    use TimestampableTrait;
    use IsActiveTrait;
    private ?string $avatar = null;
    private ?string $token;
    private ?string $password = null;

    public function __construct(private string $name, private readonly string $email)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->token = \sha1(\uniqid());
        $this->isActive = false;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
//
//    public function setEmail(string $email): void
//    {
//        $this->email = $email;
//    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    #[Pure]
    public function equals(User $user): bool
    {
        return $this->id === $user->getId();
    }

    #[ArrayShape(['id' => 'string', 'name' => 'string', 'email' => 'string', 'token' => 'string', 'active' => 'boolean', 'createdOn' => 'string', 'updatedOn' => 'string'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'token' => $this->token,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

//    Implementations

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}
