<?php

namespace App\Infrastructure\Repository\JSON;

use App\Application\Client\Repository\ClientRepositoryInterface;
use App\Application\ShippingAddress\Factory\ShippingAddressFactory;
use App\Domain\Client\Entity\Client;
use App\Domain\ShippingAddress\Entity\ShippingAddress;
use App\Infrastructure\Service\JSONHandler;
use App\Application\Client\Exception\ClientNotFoundException;

class ClientRepository implements ClientRepositoryInterface
{
    private ?array $clients;
    private JSONHandler $jsonHandler;

    public function __construct(JSONHandler $jsonHandler)
    {
        $this->jsonHandler = $jsonHandler;
        $this->clients = $this->readClients();
    }

    /**
     * {@inheritDoc}
     */
    public function getClientById(string $clientId): Client
    {
        /** @var Client $client */
        foreach ($this->clients as $client) {
            if ($client->getId() === $clientId) {
                return $client;
            }
        }

        throw new ClientNotFoundException($clientId);
    }

    public function getClients(): array
    {
        return $this->clients;
    }

    public function store(Client $client): void
    {
        foreach ($this->clients as $k => $v) {
            if ($v->getId() === $client->getId()) {
                $this->clients[$k] = $client;
            }
        }

        $data = $this->mapDataToArray($this->clients);
        $this->jsonHandler->write($data);
    }

    private function createClientFromArray(array $client, bool $readMode): Client
    {
        $clientEntity = new Client($client['id'], $client['firstname'], $client['lastname']);
        if (isset($client['addresses']) && $client['addresses']) {
            foreach ($client['addresses'] as $address) {
                $clientEntity
                    ->addAddress(
                        ShippingAddressFactory::createShippingAddressFromArray(array_values($address), $readMode)
                    );
            }
        }

        return $clientEntity;
    }

    private function mapDataToArray(array $data): array
    {
        $dataForStore = [];
        /** @var Client $client */
        foreach ($data as $client) {
            $dataForStore[] = [
                'id' => $client->getId(),
                'firstname' => $client->getFirstname(),
                'lastname' => $client->getLastname(),
                /** @var ShippingAddress $address */
                'addresses' => array_map(function($address) {
                    return [
                        'id' => $address->getId(),
                        'country' => $address->getCountry(),
                        'city' => $address->getCity(),
                        'zipcode' => $address->getZipcode(),
                        'street' => $address->getStreet(),
                        'default' => $address->isDefault()
                    ];
                }, $client->getAddresses())
            ];
        }

        return $dataForStore;
    }

    private function readClients(): array
    {
        return array_map(fn($client) => $this->createClientFromArray($client, true), $this->jsonHandler->readAll());
    }
}
