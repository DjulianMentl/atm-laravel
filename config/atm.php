<?php

use App\DTO\BanknoteNominals;
use App\DTO\CommandNames;

return [

    'users' => [
        [
            'name'     => 'Ivan',
            'lastname' => 'Ivanov',
            'login'    => 'kompot',
            'password' => 'qwer11',
        ],
        [
            'name'     => 'Sergey',
            'lastname' => 'Sergeev',
            'login'    => 'korzik',
            'password' => 'qwer111',
        ],
        [
            'name'     => 'Elena',
            'lastname' => 'Pyatakova',
            'login'    => 'karamelka',
            'password' => 'qwer22',
        ],
    ],

    'accounts' => [
        [
            'login' => 'kompot',
            'amount' => 20000
        ],
        [
            'login' => 'korzik',
            'amount' => 30000
        ],
        [
            'login' => 'karamelka',
            'amount' => 40000
        ],
    ],

    'routes' => [
        [
            'name' => 'ATM balance',
            'code' => 'A',
            'command' => CommandNames::CHECK_ATM_BALANCE
        ],
        [
            'name' => 'Account balance',
            'code' => 'B',
            'command' => CommandNames::CHECK_ACCOUNT_BALANCE
        ],
        [
            'name' => 'Deposit',
            'code' => 'D',
            'command' => CommandNames::DEPOSIT_MONEY
        ],
        [
            'name' => 'Withdraw',
            'code' => 'W',
            'command' => CommandNames::WITHDRAW_MONEY
        ],
        [
            'name' => 'Exit',
            'code' => 'E',
            'command' => CommandNames::ATM_LOGOUT
        ],
    ],

    'cells' => [

        [
            'name' => 'fifty',
            'nominal' => BanknoteNominals::FIFTY,
            'amount' => 10,
        ],
        [
            'name' => 'hundred',
            'nominal' => BanknoteNominals::HUNDRED,
            'amount' => 1,
        ],
        [
            'name' => 'two-hundred',
            'nominal' => BanknoteNominals::TWO_HUNDRED,
            'amount' => 28,
        ],
        [
            'name' => 'five-hundred',
            'nominal' => BanknoteNominals::FIVE_HUNDRED,
            'amount' => 21,
        ],
        [
            'name' => 'thousand',
            'nominal' => BanknoteNominals::THOUSAND,
            'amount' => 12,
        ],
        [
            'name' => 'two-thousand',
            'nominal' => BanknoteNominals::TWO_THOUSAND,
            'amount' => 10,
        ],
        [
            'name' => 'five-thousand',
            'nominal' => BanknoteNominals::FIVE_THOUSAND,
            'amount' => 5,
        ],
    ],
];
