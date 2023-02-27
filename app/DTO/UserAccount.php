<?php

namespace App\DTO;

use WS\Utils\Collections\Collection;

class UserAccount
{
    private string $login;
    private int $balance;

    public function __construct(array $account)
    {
        $this->login    = $account['login'];
        $this->balance  = $account['amount'];
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}
