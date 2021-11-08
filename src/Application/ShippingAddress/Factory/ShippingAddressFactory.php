<?php

namespace App\Application\ShippingAddress\Factory;

use App\Domain\ShippingAddress\Entity\ShippingAddress;

class ShippingAddressFactory
{
    private const ID_LENGTH = 4;

    public static function createShippingAddressFromArray(array $address): ShippingAddress
    {
        return (new ShippingAddress(self::generateRandomId(), ...$address));
    }

    private static function generateRandomId(): string
    {
        return substr(sha1(rand()), 0, self::ID_LENGTH);
    }
}
