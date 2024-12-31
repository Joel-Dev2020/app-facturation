<?php

namespace App\IdentityAndAccess\Application\UseCase\Command;

readonly class UpdateProfileCommand
{
    public string $id;
    public string $organization;
    public string $name;
    public string $email;
    public string $phone_number;
    public ?string $address;

    public function __construct(
        string  $id,
        ?string $organization = null,
        ?string $name = null,
        ?string $email = null,
        ?string $phone_number = null,
        ?string $address = null,
    )
    {
        $this->id = $id;
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->address = $address;
    }
}