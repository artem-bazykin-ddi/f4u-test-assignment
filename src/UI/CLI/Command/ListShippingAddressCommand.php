<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

class ListShippingAddressCommand implements CommandInterface
{
    public function getSignature(): string
    {
        return 'list_shipping_addresses';
    }

    public function execute(): void
    {
    }
}
