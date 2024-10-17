<?php

namespace App\Application\Service\Wallet;

use App\Domain\Builder\Wallet\WalletBuilderInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\Wallet;
use App\Domain\Repository\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Wallet\WalletServiceInterface;

final readonly class WalletService implements WalletServiceInterface
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
        private WalletBuilderInterface $walletBuilder,
    ) {
    }

    #[\Override]
    public function withdraw(Wallet $wallet, float $amount): void
    {
        $this->walletRepository->startTransaction();

        try {
            $this->walletRepository->withdraw($wallet, $amount);
            $this->walletRepository->commitTransaction();
        } catch (\Exception) {
            $this->walletRepository->rollbackTransaction();

            throw new \Exception("Ocorreu um erro ao realizar uma retirada.");
        }
    }

    #[\Override]
    public function deposit(Wallet $wallet, float $amount): void
    {
        $this->walletRepository->startTransaction();

        try {
            $this->walletRepository->deposit($wallet, $amount);
            $this->walletRepository->commitTransaction();
        } catch (\Exception) {
            $this->walletRepository->rollbackTransaction();

            throw new \Exception("Ocorreu um erro ao realizar um deposito.");
        }
    }

    #[\Override]
    public function findByUser(int $userId): Wallet
    {
        return $this->walletRepository->findByUser($userId);
    }

    #[\Override]
    public function createWallet(User $user): void
    {
        $this->walletRepository->startTransaction();

        try {
            $this->walletRepository->persistAndSave(
                $this->walletBuilder->build($user)
            );
            $this->walletRepository->commitTransaction();
        } catch (\Exception) {
            $this->walletRepository->rollbackTransaction();

            throw new \Exception("Ocorreu um erro ao criar a carteira.");
        }
    }
}
