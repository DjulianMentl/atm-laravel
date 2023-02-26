<?php

namespace App\DTO;

class CommandNames
{
    public const ATM_RUN = 'atm:run';

    public const ATM_GREETINGS = 'atm:greetings';
    public const ATM_USER_AUTH = 'atm:auth';
    public const ATM_MENU = 'atm:operations';

    public const CHECK_ATM_BALANCE = 'operation:atm-balance';
    public const CHECK_ACCOUNT_BALANCE = 'operation:account-balance';
    public const WITHDRAW_MONEY = 'operation:withdraw';
    public const DEPOSIT_MONEY = 'operation:deposit';
    public const ATM_LOGOUT = 'auth:logout';
}
