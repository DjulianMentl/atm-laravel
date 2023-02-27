<?php

namespace App\DTO;

class Cell
{

    private string $name;
    private int $amount;
    private int $nominal;

    public function __construct(array $cell)
    {
        $this->name = $cell['name'];
        $this->amount = $cell['amount'];
        $this->nominal = $cell['nominal'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getNominal(): int
    {
        return $this->nominal;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
