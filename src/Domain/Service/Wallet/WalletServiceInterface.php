<?php

namespace App\Domain\Service\Wallet;

use App\Domain\Entity\User;
use App\Domain\Entity\Wallet;

interface WalletServiceInterface
{
    public function withdraw(Wallet $wallet, float $amount): void;

    public function deposit(Wallet $wallet, float $amount): void;

    public function findByUser(int $userId): Wallet;

    public function createWallet(User $user): void;
}
