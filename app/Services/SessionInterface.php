<?php

namespace App\Services;

use App\DTO\User;
use DateTimeInterface;

interface SessionInterface
{
    /**
     * Сохранение в сессии данных о текущем пользователе и состоянии его счета.
     */
    public function init(User $user): void;

    /**
     * Удаление из сессии данных о текущем пользователе и состоянии его счета
     */
    public function terminate(): void;

    /**
     * Получение времени начала сеанса.
     */
    public function getStartTime(): ?DateTimeInterface;

    /**
     * Получение времени окончания сеанса.
     */
    public function getEndTime(): ?DateTimeInterface;

    /**
     * Получение данных о текущем пользователе.
     */
    public function getUser(): ?User;

    /**
     * Проверка наличия в сессии данных о пользователе.
     */
    public function isActive(): bool;

    /**
     * Получение остатка на счете текущего пользвателя.
     */
    public function getBalance(): int;

    /**
     * Пополнение лицевого счета пользователя.
     */
    public function fillInBalance($sum): void;

    /**
     * Проверка наличия запрашиваемой пользователем суммы на счете пользователя.
     */
    public function isExistSumInAccount(int $sum): bool;

    /**
     * Списание суммы со счета пользователя.
     */
    public function withdraw(int $sum): void;
}
