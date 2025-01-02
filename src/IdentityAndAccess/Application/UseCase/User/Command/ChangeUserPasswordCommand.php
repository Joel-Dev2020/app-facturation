<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;

class ChangeUserPasswordCommand
{
    public string $id;
    public ?string $currentPassword;
    public ?string $password;
    public bool $isMe;

    public function __construct(
        string  $id,
        bool    $isMe = true,
        ?string $currentPassword = null,
        ?string $password = null
    )
    {
        $this->id = $id;
        $this->password = $password;
        $this->isMe = $isMe;
        $this->currentPassword = $currentPassword;
    }
}