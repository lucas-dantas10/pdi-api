<?php

namespace App\Infrastructure\Service\TransactionAuthorizer;

use App\Adapter\TransactionAuthorizer\TransactionAuthorizerGateway;

readonly class TransactionAuthorizerService implements TransactionAuthorizerGateway
{
    public function __construct(private string $baseUrl) {}

    public function authorize(): bool
    {
        // TODO
        return true;
    }
}
