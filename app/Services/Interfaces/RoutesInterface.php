<?php

namespace App\Services\Interfaces;

interface RoutesInterface
{
    public function getCommand(string $code): string;

    public function getMenu(): array;
}
