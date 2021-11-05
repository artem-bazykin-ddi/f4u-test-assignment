<?php

namespace App\Infrastructure\Repository;

use App\Domain\Client\Client;
use App\Domain\Client\Repository\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function getClientById(string $id): ?Client
    {
        return null;
    }

    public function getClients(): array
    {
        $csv = CSVHandler::readAll();

        return array_map(fn($client) => $this->createClientFromArray($client), $csv);
    }

    private function createClientFromArray(array $client): Client
    {
        return (new Client($client['id'], $client['firstname'], $client['lastname']));
    }
}
