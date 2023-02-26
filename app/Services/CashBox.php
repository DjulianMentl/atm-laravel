<?php

namespace App\Services;

use App\DTO\Banknote;
use App\Services\Interfaces\CashBoxInterface;
use WS\Utils\Collections\Collection;

class CashBox implements CashBoxInterface
{
    private array $cells;

    public function __construct(array $cells)
    {
        $this->cells = $cells;

    }


    public function getCells(): array
    {
        $cells = [];

        foreach ($this->cells as $cell) {
            $cells[] = $cell['nominal'];
        }

        return $cells;
    }


    public function insertBanknote(Banknote $banknote): int
    {
        foreach ($this->cells as &$cell) {

            if ($cell['nominal'] === $banknote->get()) {
                $cell['amount'] += 1;

                return $cell['nominal'];
            }
        }

        return 0;
    }

    public function getBalance(): int
    {
        $balance = 0;

        foreach ($this->cells as $cell) {
            $balance += $cell['nominal'] * $cell['amount'];
        }

        return $balance;
    }


    public function takeBanknotes(int $sum): Collection
    {
        // TODO: Implement takeBanknotes() method.
    }

    private function amountBanknotesInCell()
    {

    }
}
