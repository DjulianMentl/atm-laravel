<?php

namespace App\Services;

use App\DTO\UserAccount;
use App\DTO\User;
use App\Services\Interfaces\SessionInterface;
use DateTime;
use DateTimeInterface;
use WS\Utils\Collections\Collection;

class UserSession implements SessionInterface
{
    private ?User $user;
    private Collection $userAccounts;
    private UserAccount $account;

    public function __construct(Collection $userAccounts)
    {
        $this->userAccounts = $userAccounts;
    }

    public function init(User $user): void
    {
        $this->setAccount($user);
        $this->user = $user;
    }

    private function setAccount(User $user): void
    {
        $this->userAccounts->stream()->each(function (UserAccount $account) use ($user) {
            if ($user->getLogin() === $account->getLogin()) {
                $this->account = $account;
            }
        });
    }

    public function terminate(): void
    {
        $this->user = null;
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


    public function withdraw(int $sum): void
    {
        $this->account->setBalance($this->getBalance() - $sum);
    }
}
