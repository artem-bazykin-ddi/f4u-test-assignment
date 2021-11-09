<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Client\Exception\MaxAddressesLimitExceedException;
use App\Application\Client\Repository\ClientRepositoryInterface;
use App\Application\Client\Service\ClientService;
use App\Domain\Client\Entity\Client;
use App\Domain\ShippingAddress\Entity\ShippingAddress;
use PHPUnit\Framework\TestCase;

class ClientServiceTest extends TestCase
{
    public function testMaxLimitExceed(): void
    {
        $this->expectException(MaxAddressesLimitExceedException::class);
        $repository = $this->createMock(ClientRepositoryInterface::class);
        $service = new ClientService($repository);
        $service->addAddressToClient(
            $this->createClientWithMaxCountAddresses(),
            $this->createAddress()
        );
    }

    public function testAddAddressToClient(): void
    {
        $repository = $this->createMock(ClientRepositoryInterface::class);
        $repository->method('store');
        $client = $this->createClient();
        $address = $this->createAddress();
        $service = new ClientService($repository);
        $service->addAddressToClient($client, $address);
        $this->assertSame($client->getAddresses(), [$address]);
    }

    private function createClientWithMaxCountAddresses(): Client
    {
        $client = $this->createClient();

        for ($i = 0; $i < ClientService::MAX_ADDRESSES; $i++) {
            $client->addAddress($this->createAddress());
        }

        return $client;
    }

    private function createClient(): Client
    {
        return new Client('1', 'firstname', 'lastname');
    }

    private function createAddress(): ShippingAddress
    {
        return new ShippingAddress(...array_fill(0, 5, 'test'));
    }
}
