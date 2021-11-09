<?php

declare(strict_types=1);

namespace App\Domain\Client\Entity;

use App\Domain\ShippingAddress\Entity\ShippingAddress;

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

    /**
     * @return ShippingAddress[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function addAddress(ShippingAddress $address): void
    {
        $this->addresses[] = $address;
    }

    public function setAdresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }
}
