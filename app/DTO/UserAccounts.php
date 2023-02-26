<?php

namespace App\DTO;

use WS\Utils\Collections\Collection;

class UserAccounts
{
    private Collection $accounts;

    public function __construct(Collection $accounts)
    {
        $this->accounts = $accounts;
    }

    public function get(): Collection
    {
        return $this->accounts;
    }
}
