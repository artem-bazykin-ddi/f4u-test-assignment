<?php

declare(strict_types=1);

namespace App\Application\Client\Exception;

use Exception;

class ShippingAddressNotFoundException extends Exception
{
    public function __construct(string $addressId)
    {
        parent::__construct("Shipping Address with id=$addressId not found");
    }
}
