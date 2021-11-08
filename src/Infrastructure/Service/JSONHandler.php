<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

class JSONHandler
{
    private const JSON_FILE = __DIR__ . '/../../../storage/clients.json';

    public function readAll(): array
    {
        return json_decode(file_get_contents(self::JSON_FILE), true);
    }

    public function write(array $data): void
    {
        file_put_contents(self::JSON_FILE, json_encode($data));
    }
}
