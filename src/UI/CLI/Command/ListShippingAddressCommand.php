<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

use App\Application\Client\Exception\ClientNotFoundException;
use App\Infrastructure\Repository\JSON\ClientRepository;
use App\Infrastructure\Service\JSONHandler;

class ListShippingAddressCommand implements CommandInterface
{
    public function getSignature(): string
    {
        return 'list_shipping_addresses';
    }

    public function execute(array $data = []): void
    {
        $clientRepository = new ClientRepository(new JSONHandler());
        $clientId = $data['clientId'] ?? null;

        try {
            $client = $clientRepository->getClientById($clientId);
        } catch (ClientNotFoundException $e) {
            die($e->getMessage());
        }

        print_r($client->getAddresses());
    }

    public function getParameters(): array
    {
        return ['clientId'];
    }
}
