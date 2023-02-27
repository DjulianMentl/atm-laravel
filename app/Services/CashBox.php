<?php

namespace App\Services;

use App\DTO\Banknote;
use App\DTO\Cell;
use App\Services\Interfaces\CashBoxInterface;
use Exception;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;
use WS\Utils\Collections\Functions\Comparators;
use WS\Utils\Collections\Functions\Predicates;

class CashBox implements CashBoxInterface
{
    private Collection $cells;

    public function __construct(Collection $cells)
    {
        $this->cells = $cells;

    }


    public function getCells(): array
    {
        $cells = [];

        $this->cells->stream()->each(function (Cell $cell) use (&$cells) {
            $cells[$cell->getName()] = $cell->getNominal();
        });

        return $cells;
    }



    public function insertBanknote(Banknote $banknote): int
    {
        foreach ($this->cells as $cell) {
            if ($cell->getNominal() === $banknote->get()) {
                $cell->setAmount($cell->getAmount() + 1);
                return $cell->getNominal();
            }
        }

        return 0;
    }

    public function getBalance(): int
    {
        $balance = 0;

        $this->cells->stream()->each(function (Cell $cell) use (&$balance) {
            $balance += $cell->getNominal() * $cell->getAmount();
        });

        return $balance;
    }


    /**
     * @throws Exception
     */
    public function takeBanknotes(int $sum): Collection
    {
        $result = [];

        foreach ($this->getBanknotesPacket($sum) as $banknote => $amount) {
            $result[] = 'Banknote: ' . $banknote . ', quantity: ' . $amount;
        }

        return CollectionFactory::from($result);
    }


    /**
     * @throws Exception
     */
    private function getBanknotesPacket(int $sum): array
    {
        static $result = [];
        $remainder = 0;

        $nominalsCollection = $this->getNominalsCollection();

        if (!$this->isAvailableBanknotes($nominalsCollection, $sum)) {
            $this->rollback($result);
            $result = [];
            throw new Exception("Banknote in face value '" . $sum . "' ended");
        }

        foreach ($nominalsCollection as $nominal) {

            if ($sum >= $nominal) {
                $remainder = $sum % $nominal;
                $takeAmount = ($sum - $remainder) / $nominal;

                $amountInCell = $this->checkAmountBanknotesInCell($nominal, $takeAmount);

                if ($amountInCell != $takeAmount) {
                    $remainder = $sum - $amountInCell * $nominal;
                }

                $result["$nominal"] = $amountInCell;
                break;
            }
        }

        if ($remainder == 0) {
            $tmpResult = $result;
            $result = [];
            return $tmpResult;
        }

        return $this->getBanknotesPacket($remainder);
    }


    private function isAvailableBanknotes(Collection $nominals, int $nominal): bool
    {
        $minAvailableNominal = $nominals->stream()->min(static function ($a, $b) {
            return $a <=> $b;
        });

        if ($nominal < $minAvailableNominal) {
            return false;
        }

        return true;
    }


    private function rollback(array $result): void
    {
        foreach ($result as $nominal => $amount) {
            $this->increaseAmount($nominal, $amount);
        }
    }


    private function getNominalsCollection(): Collection
    {
        return $this->cells->copy()->stream()
            ->filter(Predicates::whereGreaterThan('amount', 0))
            ->map(function (Cell $cell) {
                return $cell->getNominal();
            })
            ->sortDesc(Comparators::scalarComparator())
            ->getCollection();
    }


    private function checkAmountBanknotesInCell(int $currentNominal, int $takeAmount): ?int
    {
        foreach ($this->getAmounts() as $nominal => $amount) {

            if ($nominal == $currentNominal) {

                if  ($takeAmount <= $amount) {
                    $this->reductionAmount($currentNominal, $takeAmount);
                    return $takeAmount;
                }

                $this->reductionAmount($currentNominal, $amount);
                return $amount;
            }
        }

        return null;
    }


    private function getAmounts(): array
    {
        $amounts = [];

        $this->cells->stream()->each(function (Cell $cell) use (&$amounts) {
            $amounts[$cell->getNominal()] = $cell->getAmount();
        });

        return $amounts;
    }


    private function reductionAmount(int $nominal, int $amount): void
    {
        $this->cells->stream()->each(function (Cell $cell) use ($nominal, $amount) {
            if ($cell->getNominal() === $nominal) {
                $cell->setAmount($cell->getAmount() - $amount);
            }
        });

    }


    private function increaseAmount(int $nominal, int $amount): void
    {
        $this->cells->stream()->each(function (Cell $cell) use ($nominal, $amount) {
            if ($cell->getNominal() === $nominal) {
                $cell->setAmount($cell->getAmount() + $amount);
            }
        });

    }

}
