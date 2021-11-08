<?php

declare(strict_types=1);

namespace App\Application\Client\Service;

use App\Application\Client\Exception\MaxAddressesLimitExceedException;
use App\Application\Client\Repository\ClientRepositoryInterface;
use App\Domain\Client\Entity\Client;
use App\Domain\ShippingAddress\Entity\ShippingAddress;

class ClientService
{
    private const MAX_ADDRESSES = 3;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @throws MaxAddressesLimitExceedException
     */
    public function addAddressToClient(Client $client, ShippingAddress $shippingAddress): void
    {
        $countAddresses = count($client->getAddresses());
        $shippingAddress->setDefault(0 === $countAddresses);

        if (!$this->canAddAddress($countAddresses)) {
            throw new MaxAddressesLimitExceedException();
        }

        $client->addAddress($shippingAddress);
        $this->clientRepository->store($client);
    }

    private function canAddAddress(int $countAddresses): bool
    {
        return $countAddresses < self::MAX_ADDRESSES;
    }
}
