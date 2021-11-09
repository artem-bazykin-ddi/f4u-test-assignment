<?php

namespace App\Application\ShippingAddress\Factory;

use App\Domain\ShippingAddress\Entity\ShippingAddress;

class ShippingAddressFactory
{
    private const ID_LENGTH = 4;

    public static function createShippingAddressFromArray(array $address, bool $readMode): ShippingAddress
    {
        if ($readMode) {
            return (new ShippingAddress(...$address));
        }
        return (new ShippingAddress(self::generateRandomId(), ...$address));
    }

    private static function generateRandomId(): string
    {
        return substr(sha1(rand()), 0, self::ID_LENGTH);
    }
}
