<?php

namespace App\Services;

use App\DTO\AuthData;
use App\DTO\Banknote;
use App\DTO\BanknoteNominals;
use App\DTO\Cell;
use App\DTO\UserAccount;
use App\DTO\User;
use App\DTO\Users;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\CashBoxInterface;
use App\Services\Interfaces\RoutesInterface;
use App\Services\Interfaces\SessionInterface;
use App\Services\Interfaces\UserAuthInterface;
use Illuminate\Support\Facades\App;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;

class AtmService implements AtmInterface
{

    private SessionInterface $session;
    private RoutesInterface $handler;
    private CashBoxInterface $cashBox;

    public function __construct(SessionInterface $session, RoutesInterface $handler, CashBoxInterface $cashBox)
    {
        $this->session = $session;
        $this->handler = $handler;
        $this->cashBox = $cashBox;
    }

    public function firstCollection()
    {
       return $this->handler;

//        $a = CollectionFactory::from(config('atm.cells'))
//            ->stream()
//            ->map(function ($cell) {
//                return new Cells($cell);
//            })
//            ->getCollection()
//        ;
//
//        foreach ($a as $item) {
//            var_dump($item->getName());
//        }
//
//        $a->stream()->each(function (Cells $cell) {
//           var_dump($cell->getName());
//        });


    }


    public function getMenu(): array
    {
        return $this->handler->getMenu();
    }


    public function getCommand($code): string
    {
        return $this->handler->getCommand($code);
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

        if (!$userAuth->login($authData)) {
            return false;
        }

        $this->session->setAccount(new UserAccount($authData->getLogin(), $userAuth->getAccounts()));
        $this->session->init(new User($authData->getLogin(), $userAuth->getUsers()));

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

    /**
     * @inheritDoc
     */
    public function takeBanknotesBySum(int $sum): Collection
    {
        // TODO: Implement takeBanknotesBySum() method.
    }

    public function getSessionUserName(): ?string
    {
        return ($this->session->getUser()) ->getName();
    }


    public function getSessionStartTime(): ?string
    {
        return ($this->session->getStartTime()) ->getTimestamp();
    }


    public function getSessionEndTime(): ?string
    {
        return ($this->session->getEndTime()) ->getTimestamp();
    }
}
