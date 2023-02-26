<?php

namespace App\DTO;

use WS\Utils\Collections\Collection;

class Users
{
    private Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function get(): Collection
    {
        return $this->users;
    }
}
