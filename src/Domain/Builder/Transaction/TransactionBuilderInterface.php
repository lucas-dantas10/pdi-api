<?php

namespace App\Domain\Builder\Transaction;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\Wallet;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;

interface TransactionBuilderInterface
{
    public function build(
        CreateTransactionDTO $dto,
        Wallet $sender,
        Wallet $receiver
    ): Transaction;
}
