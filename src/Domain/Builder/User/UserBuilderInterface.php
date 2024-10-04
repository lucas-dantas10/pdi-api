<?php

namespace App\Domain\Builder\User;

use App\Domain\Entity\User;
use App\Infrastructure\Dto\User\CreateUserDTO;

interface UserBuilderInterface
{
    public function build(CreateUserDTO $dto): User;
}
