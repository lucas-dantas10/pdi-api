<?php

namespace App\Application\Builder\Transaction;

use App\Domain\Builder\Transaction\TransactionBuilderInterface;
use App\Domain\Entity\Transaction;
use App\Domain\Entity\Wallet;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;

class TransactionBuilder implements TransactionBuilderInterface
{
    public function build(
        CreateTransactionDTO $dto,
        Wallet $sender,
        Wallet $receiver,
    ): Transaction {
        return (new Transaction())
            ->setSenderWallet($sender)
            ->setReceiverWallet($receiver)
            ->setAmount($dto->getValue())
            ->setCreatedAt(new \DateTime());
    }
}
