<?php

namespace App\Domain\Service\User;

use App\Infrastructure\Dto\User\CreateUserDTO;

interface UserServiceInterface
{
    public function createUser(CreateUserDTO $dto): void;
}
