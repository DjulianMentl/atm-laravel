<?php

namespace App\Services;

use App\DTO\AuthData;
use App\DTO\Banknote;
use WS\Utils\Collections\Collection;

interface AtmInterface
{
    /**
     * Получение меню действий. Список доступных действий задается
     * в файле конфигурации /config/atm.php
     */
    public function getMenu(): array;

    /**
     * Получение имени команды, соответствующей выбранному действию пользователя в меню.
     * Список имен команд задается в файле конфигурации /config/atm.php
     */
    public function getCommand($code): string;

    /**
     * Получение списка номиналов денежных знаков, разрешенных для ввода в банкомат.
     * Список доступных номиналов задается в файле конфигурации /config/atm.php
     */
    public function getBanknotesNominals(): array;

    /**
     * Ввод банкноты в купюроприемник. Размещение банкноты в ячейке по номиналу.
     * Пополнение лицевого счета пользователя.
     */
    public function putBanknote(Banknote $banknote): void;

    /**
     * Получение суммы денежных средств, размещенных в банкомате.
     */
    public function getAmountOfMoney(): int;

    /**
     * Проверка наличия запрашиваемой пользователем суммы на счете пользователя.
     */
    public function isEnoughSumInAccount(int $sum);

    /**
     * Проверка наличия запрашиваемой пользователем суммы в банкомате.
     */
    public function isEnoughSumInAtm(int $sum);

    /**
     * Аутентификация пользователя. Старт сеанса.
     */
    public function login(AuthData $authData): bool;

    /**
     * Прекращение сеанса.
     */
    public function logout(): void;

    /**
     * Проверка наличия активного сеанса.
     */
    public function isSessionActive(): bool;

    /**
     * Получение остатка на счете текущего пользвателя.
     */
    public function getActiveSessionBalance(): int;

    /**
     * Выдача запрашиваемой суммы минимальным количеством банкнот.
     * Списание суммы со счета пользователя.
     */
    public function takeBanknotesBySum(int $sum): Collection;

    /**
     * Получение имени текущего пользвателя.
     */
    public function getSessionUserName(): ?string;

    /**
     * Получение времени начала сеанса.
     */
    public function getSessionStartTime(): ?string;

    /**
     * Получение времени окончания сеанса.
     */
    public function getSessionEndTime(): ?string;
}
