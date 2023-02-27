<?php

namespace App\Services;

use App\DTO\AuthData;
use App\DTO\Banknote;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\CashBoxInterface;
use App\Services\Interfaces\RoutesInterface;
use App\Services\Interfaces\SessionInterface;
use App\Services\Interfaces\UserAuthInterface;
use Illuminate\Support\Facades\App;
use WS\Utils\Collections\Collection;

class AtmService implements AtmInterface
{

    private SessionInterface $session;
    private RoutesInterface $routes;
    private CashBoxInterface $cashBox;

    public function __construct(SessionInterface $session, RoutesInterface $routes, CashBoxInterface $cashBox)
    {
        $this->session = $session;
        $this->routes = $routes;
        $this->cashBox = $cashBox;
    }

    public function getMenu(): array
    {
        return $this->routes->getMenu();
    }


    public function getCommand($code): string
    {
        return $this->routes->getCommand($code);
    }


    public function getBanknotesNominals(): array
    {
        return $this->cashBox->getCells();
    }

    public function putBanknote(Banknote $banknote): void
    {
        $deposit = $this->cashBox->insertBanknote($banknote);
        $this->session->fillInBalance($deposit);
    }


    public function getAmountOfMoney(): int
    {
        return $this->cashBox->getBalance();
    }


    public function isEnoughSumInAccount(int $sum): bool
    {
        return $this->session->isExistSumInAccount($sum);
    }


    public function isEnoughSumInAtm(int $sum): bool
    {
        return $this->getAmountOfMoney() >= $sum;
    }


    public function login(AuthData $authData): bool
    {
        $userAuth = App::make(UserAuthInterface::class);

        $user = $userAuth->login($authData);

        if (!$user) {
            return false;
        }

        $this->session->init($user);

        return true;
    }


    public function logout(): void
    {
        $this->session->terminate();
    }


    public function isSessionActive(): bool
    {
        return $this->session->isActive();
    }


    public function getActiveSessionBalance(): int
    {
        return $this->session->getBalance();
    }


    public function takeBanknotesBySum(int $sum): Collection
    {
        $takeBanknotes = $this->cashBox->takeBanknotes($sum);
        $this->session->withdraw($sum);
        return $takeBanknotes;
    }


    public function getSessionUserName(): ?string
    {
        return ($this->session->getUser()) ->getName();
    }


    public function getSessionStartTime(): ?string
    {
        return ($this->session->getStartTime()) ->format("d.m.Y-H:i:s");
    }


    public function getSessionEndTime(): ?string
    {
        return ($this->session->getEndTime()) ->format("d.m.Y-H:i:s");
    }


    public function isMultipleFifty(int $number): bool
    {
        return $number % 50 == 0;
    }
}
