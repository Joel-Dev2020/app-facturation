<?php

namespace App\SharedKernel\Presentation\Service\Session;

use App\SharedKernel\Domain\Service\Session\FlashInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class FlashService implements FlashInterface
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';

    public function success(string $message): void
    {
        $session = new Session();
        $session->getFlashBag()->add(self::TYPE_SUCCESS, $message);
    }

    public function info(string $message): void
    {
        $session = new Session();
        $session->getFlashBag()->add(self::TYPE_INFO, $message);
    }

    public function warning(string $message): void
    {
        $session = new Session();
        $session->getFlashBag()->add(self::TYPE_WARNING, $message);
    }

    public function danger(string $message): void
    {
        $session = new Session();
        $session->getFlashBag()->add(self::TYPE_DANGER, $message);
    }
}