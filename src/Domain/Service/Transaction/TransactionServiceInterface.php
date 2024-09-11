<?php

namespace App\Domain\Service\Transaction;

use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;

interface TransactionServiceInterface
{
    public function createTransaction(CreateTransactionDTO $dto): void;
}
