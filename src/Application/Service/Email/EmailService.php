<?php

namespace App\Application\Service\Email;

use App\Domain\Entity\User;
use App\Domain\Service\Email\EmailServiceInterface;
use App\Domain\ValueObject\Email\EmailVO;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class EmailService implements EmailServiceInterface
{
    public function __construct(private MessageBusInterface $messageBus) {}

    public function sendEmail(User $user): void
    {
        $emailVO = new EmailVO(
            to: "lucas@example.com",
            from: "transactions@me.com"
        );

        $this->messageBus->dispatch($emailVO);
    }
}
