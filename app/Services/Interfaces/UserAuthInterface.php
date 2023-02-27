<?php

namespace App\Services\Interfaces;

use App\DTO\AuthData;

interface UserAuthInterface
{
    public function login(AuthData $authData);
}
