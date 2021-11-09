<?php

namespace App\Application\Client\Exception;

use Exception;

class DeniedDeleteDefaultShippingAddressException extends Exception
{
    public function __construct(string $addressId)
    {
        parent::__construct("Denied to delete default Shipping Address with id=$addressId");
    }
}
{

}
