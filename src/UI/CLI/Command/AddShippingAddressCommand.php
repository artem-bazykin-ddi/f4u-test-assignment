<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

class AddShippingAddressCommand implements CommandInterface
{
    public function execute(): void
    {
    }


    public function getSignature(): string
    {
        return 'add';
    }
}
