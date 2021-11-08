<?php

declare(strict_types=1);

namespace App\Application\Client\Exception;

use Exception;

class ClientNotFoundException extends Exception
{
    public function __construct(string $clientId)
    {
        parent::__construct("Client with id=$clientId not found");
    }
}
