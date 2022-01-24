<?php

namespace App\Services;

use App\DTO\Banknote;
use WS\Utils\Collections\Collection;

interface CashBoxInterface
{
    /**
     * Формирование списка ячеек с номиналами для вывода пользователю
     *
     * @return int[]
     */
    public function getCells(): array;

    /**
     * Ввод банкноты в ячейку накопителя по номиналу.
     */
    public function insertBanknote(Banknote $banknote): int;

    /**
     * Получение суммы денежных средств, размещенных в накопителе.
     */
    public function getBalance(): int;

    /**
     * Выдача банкнот из накопителя по запрошенной сумме.
     * Списание суммы со счета пользователя.
     */
    public function takeBanknotes(int $sum): Collection;

}
