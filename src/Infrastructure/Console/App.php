<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\UI\CLI\Command\CommandInterface;

class App
{
    /** @var CommandInterface[] $commands */
    private array $registeredCommands = [];

    /**
     * @param string[] $commands
     */
    public function registerCommands(array $commands): void
    {
        foreach ($commands as $commandClass) {
            $command = new $commandClass;
            $this->registeredCommands[$command->getSignature()] = $command;
        }
    }

    public function run(array $argv): void
    {
        $signature = $argv[1] ?? null;
        $command = $this->getCommand($signature);
        $parameters = $command->getParameters();
        $data = [];

        if ($parameters) {
            $data = $this->parseParameters(array_slice($argv, 2), $parameters);
        }

        $command->execute($data);
    }

    private function getCommand(?string $signature): CommandInterface
    {
        if (!array_key_exists($signature, $this->registeredCommands)) {
            die("Command with signature $signature is not registered");
        }

        return $this->registeredCommands[$signature];
    }

    private function parseParameters(array $argv, array $params): array
    {
        $data = [];
        foreach ($params as $k => $v) {
            $data[$v] = $argv[$k];
        }

        return $data;
    }
}
