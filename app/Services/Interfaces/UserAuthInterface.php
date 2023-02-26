<?php

namespace App\Services\Interfaces;

use App\DTO\AuthData;
use App\DTO\Users;
use WS\Utils\Collections\Collection;

interface UserAuthInterface
{
    public function login(AuthData $authData): bool;
}
