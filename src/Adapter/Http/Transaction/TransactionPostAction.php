<?php

namespace App\Adapter\Http\Transaction;

use App\Domain\Service\Transaction\TransactionServiceInterface;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class TransactionPostAction
{
    public function __construct(
        private TransactionServiceInterface $transactionService
    ) {
    }

    #[Route(path: "/api/v1/transaction", name: "api_transaction_post", methods: ["POST"], format: "json")]
    public function __invoke(#[MapRequestPayload(acceptFormat: "json")] CreateTransactionDTO $dto): JsonResponse
    {
        $this->transactionService->createTransaction($dto);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
