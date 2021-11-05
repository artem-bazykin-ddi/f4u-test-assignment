<?php

declare(strict_types=1);

namespace App\Domain\Client;

use App\Domain\Client\ValueObject\ShippingAddress;

class Client
{
    private string $id;

    private string $firstname;

    private string $lastname;

    /** @var ShippingAddress[] $addresses */
    private array $addresses = [];

    public function __construct(string $id, string $firstname, string $lastname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function addAddresses(ShippingAddress $address): void
    {
        if (0 === count($this->addresses)) {
            $address->setDefault();
        }

        $this->addresses[] = $address;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
}
