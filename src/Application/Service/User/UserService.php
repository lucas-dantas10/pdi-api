<?php

namespace App\Application\Service\User;

use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\Service\User\UserServiceInterface;
use App\Infrastructure\Dto\User\CreateUserDTO;
use Throwable;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function createUser(CreateUserDTO $dto): void
    {
        $this->userRepository->startTransaction();

        try {
            $this->userRepository->commitTransaction();
        } catch (Throwable $e) {
            $this->userRepository->rollbackTransaction();
        }
    }
}
