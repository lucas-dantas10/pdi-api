<?php

namespace App\Application\Service\Transaction;

use App\Adapter\TransactionAuthorizer\TransactionAuthorizerGateway;
use App\Domain\Entity\Wallet;
use App\Domain\Exception\Transaction\InsufficientBalanceException;
use App\Domain\Builder\Transaction\TransactionBuilderInterface;
use App\Domain\Exception\Transaction\NotAuthorizedException;
use App\Domain\Repository\Transaction\TransactionRepositoryInterface;
use App\Domain\Service\Email\EmailServiceInterface;
use App\Domain\Service\Transaction\TransactionServiceInterface;
use App\Domain\Service\Wallet\WalletServiceInterface;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;
use Exception;

readonly class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private TransactionBuilderInterface    $transactionBuilder,
        private TransactionAuthorizerGateway   $transactionAuthorizer,
        private WalletServiceInterface         $walletService,
        private EmailServiceInterface          $emailService
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

            if (!$this->transactionAuthorizer->authorize()) {
                throw new NotAuthorizedException();
            }

            $this->transactionRepository->save($transaction);
            $this->emailService->sendEmail($walletReceiver->getUser());
            $this->transactionRepository->commitTransaction();
        } catch (InsufficientBalanceException $e) {
            $this->transactionRepository->rollbackTransaction();
            throw new InsufficientBalanceException();
        } catch (NotAuthorizedException $e) {
            $this->transactionRepository->rollbackTransaction();
            throw new NotAuthorizedException();
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
