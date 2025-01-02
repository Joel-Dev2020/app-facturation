<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;

class CreateUserCommand
{
    public ?string $organization;
    public ?string $name;
    public ?string $email;
    public ?string $phone_number;
    public ?string $password;
    public ?array $roles;
    public ?string $address;
    public ?bool $is_enabled;
    public ?bool $is_free;
    public ?SecurityUser $owner;

    public function __construct(
        ?string       $organization = null,
        ?string       $name = null,
        ?string       $email = null,
        ?string       $phone_number = null,
        ?string       $password = null,
        ?array        $roles = null,
        ?string       $address = null,
        ?bool         $is_enabled = false,
        ?bool         $is_free = false,
        ?SecurityUser $owner = null,
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
        $this->is_free = $is_free;
        $this->owner = $owner;
    }
}