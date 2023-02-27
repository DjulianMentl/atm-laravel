<?php

namespace App\DTO;

class Banknote
{
    private  int $banknote;

    public function __construct(int $banknote)
    {
        $this->banknote = $banknote;
    }

    public function get(): int
    {
        return $this->banknote;
    }
}
