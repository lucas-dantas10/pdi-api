<?php

namespace App\Adapter\Http\Transaction;

use App\Infrastructure\Dto\Transaction\CreateTransactionDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class TransactionPostAction
{
    #[Route(path: "/api/v1/transaction", name: "api_transaction_post", methods: ["POST"], format: "json")]
    public function __invoke(#[MapRequestPayload(acceptFormat: "json")] CreateTransactionDTO $dto): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
