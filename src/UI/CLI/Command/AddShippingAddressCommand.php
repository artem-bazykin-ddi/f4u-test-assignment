<?php

declare(strict_types=1);

namespace App\UI\CLI\Command;

use App\Application\Client\Exception\MaxAddressesLimitExceedException;
use App\Application\Client\Service\ClientService;
use App\Application\ShippingAddress\Factory\ShippingAddressFactory;
use App\Application\Client\Exception\ClientNotFoundException;
use App\Infrastructure\Repository\JSON\ClientRepository;
use App\Infrastructure\Service\JSONHandler;

class AddShippingAddressCommand implements CommandInterface
{
    public function getSignature(): string
    {
        return 'add';
    }

    /**
     * @throws MaxAddressesLimitExceedException
     */
    public function execute(array $data = []): void
    {
        $clientRepository = new ClientRepository(new JSONHandler());
        $clientService = new ClientService($clientRepository);
        $clientId = $data['clientId'];

        try {
            $client = $clientRepository->getClientById($clientId);
        } catch (ClientNotFoundException $e) {
            die($e->getMessage());
        }

        $shippingData = array_values(array_slice($data, 1));
        $shippingAddress = ShippingAddressFactory::createShippingAddressFromArray($shippingData, false);
        $clientService->addAddressToClient($client, $shippingAddress);
    }

    public function getParameters(): array
    {
        return ['clientId', 'country', 'city', 'zipcode', 'street'];
    }
}
