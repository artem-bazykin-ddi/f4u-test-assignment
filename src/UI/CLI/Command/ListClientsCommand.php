<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

use App\Infrastructure\Repository\JSON\ClientRepository;
use App\Infrastructure\Service\JSONHandler;

class ListClientsCommand implements CommandInterface
{
    public function getSignature(): string
    {
        return 'list_clients';
    }

    public function execute(array $data = []): void
    {
        $repo = new ClientRepository(new JSONHandler());
        $clients = $repo->getClients();

        print_r($clients);
    }

    public function getParameters(): array
    {
        return [];
    }
}
