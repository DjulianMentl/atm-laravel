<?php

namespace App\DTO;

use WS\Utils\Collections\Collection;

class UserAccount
{
    private string $login;
    private string $balance;

    public function __construct(string $login, Collection $accounts)
    {
        $accounts->stream()->each(function ($account) use ($login) {

            if ($account['login'] === $login) {
                $this->login    = $account['login'];
                $this->balance  = $account['amount'];
            }
        });
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): void
    {
        $this->balance = $balance;
    }
}
