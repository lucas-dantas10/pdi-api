<?php

namespace App\Application\Service\User;

use App\Domain\Builder\User\UserBuilderInterface;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\Service\User\UserServiceInterface;
use App\Domain\Service\Wallet\WalletServiceInterface;
use App\Infrastructure\Dto\User\CreateUserDTO;
use Exception;
use Throwable;

final readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserBuilderInterface $userBuilder,
        private WalletServiceInterface $walletService
    ) {
    }

    public function createUser(CreateUserDTO $dto): void
    {
        $this->userRepository->startTransaction();

        try {
            $user = $this->userBuilder->build($dto);

            $this->userRepository->persistAndSave($user);
            $this->walletService->createWallet($user);
            $this->userRepository->commitTransaction();
        } catch (Throwable $e) {
            $this->userRepository->rollbackTransaction();
            throw new Exception("Ocorreu um erro ao criar o usuário.");
        }
    }
}
