<?php

namespace App\core\Application\UseCase\User\DeleteUser;

use App\core\Application\UseCase\User\DeleteUser\DTO\DeleteUserInputDTO;
use App\core\Domain\Repository\UserRepository;

class DeleteUser
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function handle(DeleteUserInputDTO $dto): void
    {
        $customer = $this->userRepository->findOneByIdOrFail($dto->id);

        $this->userRepository->remove($customer);
    }
}