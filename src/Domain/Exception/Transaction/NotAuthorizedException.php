<?php

namespace App\Domain\Exception\Transaction;

use Exception;
use Throwable;

class NotAuthorizedException extends Exception
{
    private const string MESSAGE = 'Transação não autorizada';

    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? self::MESSAGE, $code, $previous);
    }
}
