<?php

namespace App\Application\Service\Transaction;

use App\Application\Service\Wallet\WalletService;
use App\Domain\Entity\Wallet;
use App\Domain\Exception\Transaction\InsufficientBalanceException;
use App\Domain\Builder\Transaction\TransactionBuilderInterface;
use App\Domain\Repository\Transaction\TransactionRepositoryInterface;
use App\Domain\Service\Transaction\TransactionServiceInterface;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;
use Exception;

readonly class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private TransactionBuilderInterface    $transactionBuilder,
        private WalletService $walletService
    ) {
    }

    public function createTransaction(CreateTransactionDTO $dto): void
    {
        $this->transactionRepository->startTransaction();

        try {
            $walletSender = $this->walletService->findByUser($dto->getPayer());
            $walletReceiver = $this->walletService->findByUser($dto->getPayee());

            if ($this->balanceIsInvalid($dto, $walletSender)) {
                throw new InsufficientBalanceException();
            }

            $this->walletService->withdraw($walletSender, $dto->getValue());
            $this->walletService->deposit($walletReceiver, $dto->getValue());

            $transaction = $this->transactionBuilder->build($dto, $walletSender, $walletReceiver);

            $walletSender->addSentTransaction($transaction);
            $walletReceiver->addReceivedTransaction($transaction);

            $this->transactionRepository->save($transaction);
            $this->transactionRepository->commitTransaction();
        } catch (InsufficientBalanceException $e) {
            $this->transactionRepository->rollbackTransaction();
            throw new InsufficientBalanceException();
        } catch (Exception $e) {
            $this->transactionRepository->rollbackTransaction();
            throw new Exception("Ocorreu um erro ao criar a transação.");
        }
    }

    private function balanceIsInvalid(CreateTransactionDTO $dto, Wallet $walletSender): bool
    {
        return $dto->getValue() > $walletSender->getBalance();
    }
}
