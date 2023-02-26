<?php

namespace App\Services;

use App\Console\Commands\AtmAuth;

class UserValidator
{

    private int $failedAttempts = 0;

    public function validateLogin(?string $login, AtmAuth $userLogin): bool
    {
        if (empty($login)) {

            $userLogin->warn('Empty login');
            $this->countFailedAttempts($userLogin);

            return false;
        }

        if (!$this->isValidateLogin($login) ) {

           $userLogin->warn('Incorrect login');
            $this->countFailedAttempts($userLogin);

           return false;
        }

        $this->failedAttempts = 0;

        return true;
    }

    private function isValidateLogin(string $name): bool
    {
        return preg_match('/^[a-zA-Z0-9_.-]{3,25}$/', $name);
    }

    public function validatePassword(?string $password, AtmAuth $userPassword): bool
    {
        if (empty($password)) {

            $userPassword->warn('Empty password');
            $this->countFailedAttempts($userPassword);

            return false;
        }

        if (!$this->isValidatePassword($password)) {

            $userPassword->warn('Incorrect password');
            $this->countFailedAttempts($userPassword);

            return false;
        }

        return true;
    }

    private function isValidatePassword(string $password): bool
    {
        return preg_match('/^[a-zA-Z0-9_.?*!-]{6,25}$/', $password);
    }

    private function countFailedAttempts(AtmAuth $userAuth)
    {
        $this->failedAttempts++;

        if ($this->failedAttempts === 3) {
            $userAuth->error('The limit of attempts has been reached. Try again in 10 minutes.');
            exit;
        }
    }
}
