<?php

namespace App\Infrastructure\Service\TransactionAuthorizer;

use App\Adapter\TransactionAuthorizer\TransactionAuthorizerGateway;

class TransactionAuthorizer implements TransactionAuthorizerGateway
{
    private const string URL_BASE = '%env(resolve:TRANSACTION_AUTHORIZER_URL)%';
    public function authorize(): bool
    {
        dd(self::URL_BASE);
        // TODO
        return true;
    }
}
