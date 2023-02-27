<?php

namespace App\Console\Commands;

use App\DTO\AuthData;
use App\DTO\CommandNames;
use App\DTO\UserAccounts;
use App\DTO\User;
use App\DTO\Users;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\SessionInterface;
use App\Services\UserValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class AtmAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::ATM_USER_AUTH;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ATM auth';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(AtmInterface $atm, UserValidator $validator)
    {
        $login = $this->getLogin($validator);
        $password = $this->getPassword($validator);

        if (!$atm->login(new AuthData($login, $password))) {
            $this->error('User is not found. Enter the correct username and password.');
            exit;
        }

        $this->info('Hello ' . $atm->getSessionUserName());
        $this->info('Session start: ' . $atm->getSessionStartTime());
    }


    private function getLogin(UserValidator $validator, string $loginMessage = 'Enter login'): string
    {
        $login = $this->ask($loginMessage);

        if (!$validator->validateLogin($login, $this)) {
            return $this->getLogin($validator, 'Please enter your login again');
        }

        return $login;
    }


    private function getPassword(UserValidator $validator, string $passwordMessage = 'Enter password'): string
    {
        $password = $this->secret($passwordMessage);

        if (!$validator->validatePassword($password, $this)) {
            return $this->getPassword($validator, 'Please enter your password again');
        }

        return $password;
    }
}
