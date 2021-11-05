<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

class CSVHandler
{
    public static function read(): array
    {
        return [];
    }

    public static function readAll(): array
    {
        $csv = array_map('str_getcsv', file(__DIR__ . '/../../../storage/clients.csv'));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); # remove column header

        return $csv;
    }

    public static function write(): void
    {
    }
}
