<?php

namespace App\Application\Service\Wallet;

use App\Domain\Entity\Wallet;
use App\Domain\Repository\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Wallet\WalletServiceInterface;
use Exception;

readonly class WalletService implements WalletServiceInterface
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    public function withdraw(Wallet $wallet, float $amount): void
    {
        $this->walletRepository->startTransaction();

        try {
            $this->walletRepository->withdraw($wallet, $amount);
            $this->walletRepository->commitTransaction();
        } catch (Exception $e) {
            $this->walletRepository->rollbackTransaction();
            throw new Exception("Ocorreu um erro ao realizar uma retirada.");
        }
    }

    public function deposit(Wallet $wallet, float $amount): void
    {
        $this->walletRepository->startTransaction();

        try {
            $this->walletRepository->deposit($wallet, $amount);
            $this->walletRepository->commitTransaction();
        } catch (Exception $e) {
            $this->walletRepository->rollbackTransaction();
            throw new Exception("Ocorreu um erro ao realizar um deposito.");
        }
    }

    public function findByUser(int $userId): Wallet
    {
        return $this->walletRepository->findByUser($userId);
    }
}
