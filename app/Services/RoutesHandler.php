<?php

namespace App\Services;

use App\Services\Interfaces\RoutesInterface;
use WS\Utils\Collections\Collection;

class RoutesHandler implements RoutesInterface
{
    private array $commands;
    private array $menu;

    public function __construct(Collection $routes)
    {
        $routes->stream()->each(function ($route) {
            $this->commands[$route['code']] = $route['command'];
            $this->menu[$route['code']]     = $route['name'];
        });

    }

    public function getCommand(string $code): string
    {
        return $this->commands[$code];
    }

    public function getMenu(): array
    {
        return $this->menu;
    }
}
