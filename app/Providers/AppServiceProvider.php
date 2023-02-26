<?php

namespace App\Providers;

use App\DTO\Banknote;
use App\DTO\UserAccount;
use App\DTO\UserAccounts;
use App\DTO\Users;
use App\Services\AtmService;
use App\Services\CashBox;
use App\Services\RoutesHandler;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\CashBoxInterface;
use App\Services\Interfaces\RoutesInterface;
use App\Services\Interfaces\SessionInterface;
use App\Services\Interfaces\UserAuthInterface;
use App\Services\UserAuth;
use App\Services\UserSession;
use Illuminate\Support\ServiceProvider;
use WS\Utils\Collections\CollectionFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AtmInterface::class, AtmService::class);
        $this->app->singleton(SessionInterface::class, UserSession::class);
        $this->app->singleton(CashBoxInterface::class, CashBox::class);

        $this->app->singleton(RoutesInterface::class, function () {
            return new RoutesHandler(CollectionFactory::from(config('atm.routes')));
        });

        $this->app->singleton(Users::class, function () {
            return new Users(CollectionFactory::from(config('atm.users')));
        });

        $this->app->singleton(UserAccounts::class, function () {
            return new UserAccounts(CollectionFactory::from(config('atm.accounts')));
        });

        $this->app->bind(UserAuthInterface::class, UserAuth::class);

        $this->app->when(CashBox::class)
            ->needs('$cells')
            ->giveConfig('atm.cells');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
