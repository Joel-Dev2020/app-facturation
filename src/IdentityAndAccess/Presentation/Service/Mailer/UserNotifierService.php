<?php

namespace App\IdentityAndAccess\Presentation\Service\Mailer;


use App\SharedKernel\Domain\Service\Mailer\MailerServiceInterface;
use App\SharedKernel\Presentation\Service\Mailer\MailerService;

readonly class UserNotifierService implements MailerServiceInterface
{
    public function __construct(private MailerService $mailer)
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
        $this->mailer->send(to: $to, subject: $subject, body: $body, template: $template, data: $data);
    }
}