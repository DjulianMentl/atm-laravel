<?php

namespace App\Services;

use App\DTO\AuthData;
use App\DTO\User;
use App\Services\Interfaces\UserAuthInterface;
use WS\Utils\Collections\Collection;

class UserAuth implements UserAuthInterface
{

    private Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }


    public function login(AuthData $authData): ?User
    {
        foreach ($this->users as $user) {

            if ($user->getLogin() === $authData->getLogin() && $user->getPassword() === $authData->getPassword()) {
                return $user;
            }
        }

        return null;
    }
}
