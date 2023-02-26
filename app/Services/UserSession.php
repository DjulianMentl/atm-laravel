<?php

namespace App\Services;

use App\DTO\UserAccount;
use App\DTO\User;
use App\Services\Interfaces\SessionInterface;
use DateTime;
use DateTimeInterface;

class UserSession implements SessionInterface
{
    private ?User $user;
    private ?UserAccount $account;

    public function init(User $user): void
    {
        $this->user = $user;
    }

    public function setAccount(UserAccount $account)
    {
        $this->account = $account;
    }

    public function terminate(): void
    {
        $this->user = null;
        $this->account = null;
    }


    public function getStartTime(): ?DateTimeInterface
    {
        return new DateTime('now');
    }


    public function getEndTime(): ?DateTimeInterface
    {
        return new DateTime('now');
    }


    public function getUser(): ?User
    {
        return $this->user;
    }


    public function isActive(): bool
    {
        return isset($this->user);
    }


    public function getBalance(): int
    {
        return $this->account->getBalance();
    }


    public function fillInBalance($sum): void
    {
        $this->account->setBalance($this->getBalance() + $sum);
    }


    public function isExistSumInAccount(int $sum): bool
    {
        return $this->getBalance() >= $sum;
    }

    /**
     * @inheritDoc
     */
    public function withdraw(int $sum): void
    {
        // TODO: Implement withdraw() method.
    }
}
