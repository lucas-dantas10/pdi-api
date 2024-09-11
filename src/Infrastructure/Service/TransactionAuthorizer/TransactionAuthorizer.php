<?php

namespace App\Infrastructure\Service\TransactionAuthorizer;

use App\Adapter\TransactionAuthorizer\TransactionAuthorizerGateway;

class TransactionAuthorizer implements TransactionAuthorizerGateway
{
    public function authorize(): bool
    {
        // TODO
        return true;
    }
}
