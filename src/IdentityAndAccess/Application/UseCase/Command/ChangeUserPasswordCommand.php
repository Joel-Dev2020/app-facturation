<?php

namespace App\IdentityAndAccess\Application\UseCase\Command;

readonly class ChangeUserPasswordCommand
{
    public string $id;
    public ?string $currentPassword;
    public string $password;
    public bool $isMe;

    public function __construct(
        string  $id,
        string  $password,
        bool    $isMe = true,
        ?string $currentPassword = null
    )
    {
        $this->id = $id;
        $this->password = $password;
        $this->isMe = $isMe;
        $this->currentPassword = $currentPassword;
    }
}