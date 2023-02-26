<?php

namespace App\DTO;

use WS\Utils\Collections\Collection;

class User
{
    private string $name;
    private string $lastname;
    private string $login;
    private string $password;

    public function __construct(string $login, Collection $users)
    {

        $users->stream()->each(function ($user) use ($login) {
            if ($user['login'] === $login) {

                $this->name     = $user['name'];
                $this->lastname = $user['lastname'];
                $this->login    = $user['login'];
                $this->password = $user['password'];
            }
        });

//        foreach ($users as $user) {
//
//            if ($user['login'] === $login) {
//
//                $this->name     = $user['name'];
//                $this->lastname = $user['lastname'];
//                $this->login    = $user['login'];
//                $this->password = $user['password'];
//            }
//        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getLogin(): string
    {
        return $this->login;
    }
}
