<?php

namespace App\UI\CLI\Command;

interface CommandInterface
{
    public function getSignature(): string;

    public function execute(): void;
}
