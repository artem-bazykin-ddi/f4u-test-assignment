<?php

declare(strict_types=1);

namespace App\Domain\Client\Repository;

use App\Domain\Client\Client;

interface ClientRepositoryInterface
{
    public function getClientById(string $id): ?Client;

    /**
     * @return Client[]
     */
    public function getClients(): array;
}
