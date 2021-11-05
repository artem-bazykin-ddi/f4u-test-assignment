<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

use App\Infrastructure\Repository\ClientRepository;

class ListClientsCommand implements CommandInterface
{

    public function getSignature(): string
    {
        return 'list_clients';
    }

    public function execute(): void
    {
        $repo = new ClientRepository();
        $clients = $repo->getClients();

        print_r($clients);
    }
}
