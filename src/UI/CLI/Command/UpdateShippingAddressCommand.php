<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

use App\Application\Client\Exception\ClientNotFoundException;
use App\Application\Client\Exception\ShippingAddressNotFoundException;
use App\Application\Client\Service\ClientService;
use App\Infrastructure\Repository\JSON\ClientRepository;
use App\Infrastructure\Service\JSONHandler;

class UpdateShippingAddressCommand implements CommandInterface
{

    public function getSignature(): string
    {
        return 'update';
    }

    public function execute(array $data = []): void
    {
        $clientRepository = new ClientRepository(new JSONHandler());
        $clientService = new ClientService($clientRepository);
        $clientId = $data['clientId'];
        $addressId = $data['addressId'];
        $shippingData = array_values(array_slice($data, 2));

        try {
            $client = $clientRepository->getClientById($clientId);
        } catch (ClientNotFoundException $e) {
            die($e->getMessage());
        }

        try {
            $client = $clientService->updateShippingAddress($client, $addressId, $shippingData);
        } catch (ShippingAddressNotFoundException $e) {
            die($e->getMessage());
        }

        $clientRepository->store($client);
    }

    public function getParameters(): array
    {
        return ['clientId', 'addressId', 'country', 'city', 'zipcode', 'street'];
    }
}
