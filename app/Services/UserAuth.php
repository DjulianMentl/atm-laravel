<?php

namespace App\Services;

use App\DTO\AuthData;
use App\DTO\UserAccounts;
use App\DTO\Users;
use App\Services\Interfaces\UserAuthInterface;
use WS\Utils\Collections\Collection;

class UserAuth implements UserAuthInterface
{

    private Users $users;
    private UserAccounts $accounts;

    public function __construct(Users $users, UserAccounts $accounts)
    {
        $this->users = $users;
        $this->accounts = $accounts;
    }


    public function login(AuthData $authData): bool
    {

        if (!$this->authVerification($authData->getLogin(), $authData->getPassword(), $this->users->get())) {
            return false;
        }

        if (!$this->paymentAccountVerification($authData->getLogin(), $this->accounts->get())) {
            return false;
        }

        return true;
    }


    private function authVerification(string $login, string $password, Collection $users): bool
    {
        foreach ($users as $user) {

            if ($user['login'] === $login && $user["password"] === $password) {
                return true;
            }
        }

        return false;
    }


    private function paymentAccountVerification(string $login, Collection $accounts): bool
    {
        foreach ($accounts as $account) {

            if ($account['login'] === $login) {
                return true;
            }
        }

        return false;
    }

    public function getUsers(): Collection
    {
        return $this->users->get();
    }

    public function getAccounts(): Collection
    {
        return $this->accounts->get();
    }
}
