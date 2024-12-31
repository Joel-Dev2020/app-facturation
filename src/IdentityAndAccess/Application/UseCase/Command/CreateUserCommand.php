<?php

namespace App\IdentityAndAccess\Application\UseCase\Command;

readonly class CreateUserCommand
{
    public string $organization;
    public string $name;
    public string $email;
    public string $phone_number;
    public string $password;
    public array $roles;
    public ?string $address;
    public bool $is_enabled;

    public function __construct(
        string  $organization,
        string  $name,
        string  $email,
        string  $phone_number,
        string  $password,
        array   $roles,
        ?string $address = null,
        bool    $is_enabled = false,
    )
    {
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->roles = $roles;
        $this->password = $password;
        $this->address = $address;
        $this->is_enabled = $is_enabled;
    }
}