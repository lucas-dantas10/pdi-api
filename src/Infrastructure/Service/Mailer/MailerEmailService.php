<?php

namespace App\Infrastructure\Service\Mailer;

use App\Adapter\Email\EmailServiceGateway;
use App\Domain\ValueObject\Email\EmailVO;
use Exception;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerEmailService implements EmailServiceGateway
{
    public function __construct(
      private MailerInterface $mailer
    ) {
    }

    public function sendEmail(EmailVO $emailVO): void
    {
        try {
            $email = (new Email())
                ->from($emailVO->getFrom())
                ->to($emailVO->getTo())
                ->subject("Transação realizada com sucesso!")
                ->text("Você recebeu uma transação com sucesso!");

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new Exception("Erro ao enviar email");
        }
    }
}
