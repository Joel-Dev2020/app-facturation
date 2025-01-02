<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;

class UpdateUserCommand
{
    public string $id;
    public string $organization;
    public string $name;
    public string $email;
    public string $phone_number;
    public ?string $address;
    public bool $enabled;
    public bool $is_free;

    public function __construct(
        string  $id,
        ?string $organization = null,
        ?string $name = null,
        ?string $email = null,
        ?string $phone_number = null,
        ?string $address = null,
        bool    $enabled = false,
        bool    $is_free = false,
    )
    {
        $this->id = $id;
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->address = $address;
        $this->enabled = $enabled;
        $this->is_free = $is_free;
    }
}