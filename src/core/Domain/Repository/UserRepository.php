<?php

declare(strict_types=1);

namespace App\core\Domain\Repository;

use App\core\Domain\Model\User;

interface UserRepository
{
    public function findOneByIdOrFail(string $id): User;

    public function save(User $user): void;

    public function remove(User $user): void;
//    public function findOneUserAndIsActive(User $user): void;
}
