<?php

namespace App\Action\Transaction;

use App\Domain\Service\Transaction\TransactionServiceInterface;
use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final readonly class CreateTransactionPostAction
{
    public function __construct(
        private TransactionServiceInterface $transactionService
    ) {
    }

    #[OA\Tag("Transaction")]
    #[OA\Post(description: "Create Transaction", summary: "Create Transaction")]
    #[OA\RequestBody(request: CreateTransactionDTO::class)]
    #[OA\Response(response: 201, description: "Created")]
    #[OA\Response(response: 422, description: "Unprocessable Entity")]
    #[Route(path: "/api/v1/create/transaction", name: "api_transaction_post", methods: ["POST"], format: "json")]
    public function __invoke(#[MapRequestPayload(acceptFormat: "json")] CreateTransactionDTO $dto): JsonResponse
    {
        $this->transactionService->createTransaction($dto);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
