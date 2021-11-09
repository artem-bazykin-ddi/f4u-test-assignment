<?php

declare(strict_types=1);

namespace App\Application\Client\Service;

use App\Application\Client\Exception\DeniedDeleteDefaultShippingAddressException;
use App\Application\Client\Exception\MaxAddressesLimitExceedException;
use App\Application\Client\Exception\ShippingAddressNotFoundException;
use App\Application\Client\Repository\ClientRepositoryInterface;
use App\Application\ShippingAddress\Factory\ShippingAddressFactory;
use App\Domain\Client\Entity\Client;
use App\Domain\ShippingAddress\Entity\ShippingAddress;

class ClientService
{
    public const MAX_ADDRESSES = 3;

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

    /**
     * @throws DeniedDeleteDefaultShippingAddressException
     * @throws ShippingAddressNotFoundException
     */
    public function deleteShippingAddress(Client $client, string $addressId): Client
    {
        /** @var ShippingAddress $address */
        $addresses = array_filter(array_map(function($address) use ($addressId) {
            if ($address->getId() === $addressId) {
                if ($address->isDefault()) {
                    throw new DeniedDeleteDefaultShippingAddressException($addressId);
                }
            } else {
                return $address;
            }
        }, $client->getAddresses()));

        if (count($addresses) === count($client->getAddresses())) {
            throw new ShippingAddressNotFoundException($addressId);
        }

        $client->setAdresses($addresses);

        return $client;
    }

    /**
     * @throws \App\Application\Client\Exception\ShippingAddressNotFoundException
     */
    public function updateShippingAddress(Client $client, string $addressId, array $data): Client
    {
        $isUpdated = false;
        $addresses = array_filter(
            array_map(function($address) use ($addressId, $data, &$isUpdated) {
                if ($address->getId() === $addressId) {
                    $isUpdated = true;

                    return ShippingAddressFactory::createShippingAddressFromArray(
                        [$address->getId(), ...$data, $address->isDefault()], true
                    );
                }

                return  $address;
            }, $client->getAddresses()));

        if ($isUpdated) {
            $client->setAdresses($addresses);
        } else {
            throw new ShippingAddressNotFoundException($addressId);
        }


        return $client;
    }
}
