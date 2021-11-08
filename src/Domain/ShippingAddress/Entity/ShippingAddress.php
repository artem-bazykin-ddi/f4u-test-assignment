<?php

declare(strict_types=1);

namespace App\Domain\ShippingAddress\Entity;

class ShippingAddress
{
    private string $id;

    private string $country;

    private string $city;

    private string $zipcode;

    private string $street;

    private bool $default;

    public function __construct(string $id, string $country, string $city, string $zipcode, string $street, bool $default = false)
    {
        $this->id = $id;
        $this->country = $country;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->street = $street;
        $this->default = $default;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }
}
