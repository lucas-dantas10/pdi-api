<?php

namespace App\Application\Service\Email;

use App\Adapter\Email\EmailServiceGateway;
use App\Domain\Entity\User;
use App\Domain\Service\Email\EmailServiceInterface;
use App\Domain\ValueObject\Email\EmailVO;

readonly class EmailService implements EmailServiceInterface
{
    public function __construct(
        private EmailServiceGateway $emailGateway
    ) {
    }

    public function sendEmail(User $user): void
    {
        $emailVO = new EmailVO(
            to: "lucas@example.com",
            from: "transactions@me.com"
        );

        $this->emailGateway->sendEmail($emailVO);
    }
}
