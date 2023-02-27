<?php

namespace App\Providers;

use App\DTO\Cell;
use App\DTO\User;
use App\DTO\UserAccount;
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

        $this->app->singleton(CashBoxInterface::class, function () {
            return new CashBox(CollectionFactory::from(config('atm.cells'))->stream()->map(
                function ($cell) {
                    return new Cell($cell);
                }
            )->getCollection());
        });

        $this->app->singleton(SessionInterface::class, function () {
            return new UserSession(CollectionFactory::from(config('atm.accounts'))->stream()->map(
                function ($account) {
                    return new UserAccount($account);
                })->getCollection());
        });


        $this->app->singleton(UserAuthInterface::class, function () {
            return new UserAuth(CollectionFactory::from(config('atm.users'))->stream()->map(
                function ($user) {
                    return new User($user);
                })->getCollection());
        });

        $this->app->singleton(RoutesInterface::class, function () {
            return new RoutesHandler(CollectionFactory::from(config('atm.routes')));
        });

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
