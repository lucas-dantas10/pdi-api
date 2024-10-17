<?php

namespace App\Infrastructure\Service\Queue;

use App\Adapter\Email\EmailServiceGateway;
use App\Domain\ValueObject\Email\EmailVO;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class EmailQueueHandler
{
    public function __construct(private EmailServiceGateway $emailService)
    {
    }

    public function __invoke(EmailVO $emailVO): void
    {
        $this->emailService->sendEmail($emailVO);
    }
}
