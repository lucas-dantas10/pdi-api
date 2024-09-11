<?php

namespace App\Domain\Repository\Transaction;

use App\Domain\Entity\Transaction;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction): void;
    public function startTransaction(): void;
    public function commitTransaction(): void;
    public function rollbackTransaction(): void;
}