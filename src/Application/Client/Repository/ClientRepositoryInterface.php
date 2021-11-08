<?php

declare(strict_types=1);

namespace App\Application\Client\Repository;

use App\Domain\Client\Entity\Client;
use App\Application\Client\Exception\ClientNotFoundException;

interface ClientRepositoryInterface
{
    /**
     * @throws ClientNotFoundException
     */
    public function getClientById(string $clientId): Client;

    /**
     * @return Client[]
     */
    public function getClients(): array;

    public function store(Client $client): void;
}
