<?php

namespace App\SharedKernel\Presentation\Service\Mailer;

use App\SharedKernel\Domain\Service\Mailer\MailerServiceInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class MailerService implements MailerServiceInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private MailerInterface $mailer,
        private string          $senderEmail,
        private string          $senderName,
    )
    {
    }

    public function send(
        string  $to,
        string  $subject,
        ?string $body = null,
        ?string $template = null,
        ?array  $data = []
    ): void
    {
        $email = new TemplatedEmail();
        $email->from(new Address($this->senderEmail, $this->senderName))
            ->to(new Address($to, $subject))
            ->subject($subject)
            ->context($data);
        if ($body) {
            $email->html($body);
        } else {
            $email->htmlTemplate($template);
        }
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Log the error for debugging purposes
            $this->logger->error('Failed to send email.', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);

            // Optionally, throw a custom exception or handle the error
            throw new RuntimeException(sprintf(
                "Impossible d'envoyer un courriel à %s avec l'objet %s. Veuillez réessayer plus tard.",
                $to,
                $subject
            ));
        }
    }
}