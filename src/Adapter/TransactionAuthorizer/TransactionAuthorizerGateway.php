<?php

namespace App\Adapter\TransactionAuthorizer;

interface TransactionAuthorizerGateway
{
    public function authorize(): bool;
}
