<?php

namespace App\Application\Builder\User;

use App\Domain\Builder\User\UserBuilderInterface;
use App\Domain\Entity\User;
use App\Domain\Enum\RoleUser\RoleUserEnum;
use App\Infrastructure\Dto\User\CreateUserDTO;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserBuilder implements UserBuilderInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function build(CreateUserDTO $dto): User
    {
        $role = [
            'role' => RoleUserEnum::getById($dto->getTipoUsuario())->name
        ];

        $user = (new User())
            ->setFullName($dto->getFullName())
            ->setCpf($dto->getCpf())
            ->setEmail($dto->getEmail())
            ->setRoles($role);

        $password = $this->passwordHasher->hashPassword(
            $user,
            $dto->getPassword()
        );
        $user->setPassword($password);

        return $user;
    }
}
