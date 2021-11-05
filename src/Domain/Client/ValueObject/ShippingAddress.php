<?php

declare(strict_types=1);

namespace App\Domain\Client\ValueObject;

class ShippingAddress
{
    private string $country;

    private string $city;

    private string $zipcode;

    private string $street;

    private bool $default = false;

    public function __construct(string $country, string $city, string $zipcode, string $street)
    {
        $this->country = $country;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->street = $street;
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

    public function setDefault(): void
    {
        $this->default = true;
    }
}
