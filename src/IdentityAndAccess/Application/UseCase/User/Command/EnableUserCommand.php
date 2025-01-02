<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;

class EnableUserCommand
{
    public string $id;
    public bool $enabled;

    public function __construct(string $id, bool $enabled)
    {
        $this->id = $id;
        $this->enabled = $enabled;
    }
}