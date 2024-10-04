<?php

namespace App\Domain\Repository\Wallet;

use App\Domain\Entity\Wallet;

interface WalletRepositoryInterface
{
    public function withdraw(Wallet $wallet, float $amount): void;
    public function deposit(Wallet $wallet, float $amount): void;
    public function findByUser(int $userId): Wallet;
    public function startTransaction(): void;
    public function commitTransaction(): void;
    public function rollbackTransaction(): void;
    public function persist(Wallet $wallet): void;
    public function save(): void;
    public function persistAndSave(Wallet $wallet): void;
}
