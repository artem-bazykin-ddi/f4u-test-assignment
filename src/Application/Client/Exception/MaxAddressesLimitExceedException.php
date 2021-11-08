<?php

declare(strict_types=1);

namespace App\Application\Client\Exception;

use Exception;

class MaxAddressesLimitExceedException extends Exception
{
    public function __construct()
    {
        parent::__construct("Can't add shipping address because of the limit");
    }
}
