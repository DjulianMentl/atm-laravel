<?php

namespace App\Console\Commands;

use App\DTO\Banknote;
use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\CashBoxInterface;
use Illuminate\Console\Command;

class Deposit extends Command
{
    /**
     * @var string
     */
    protected $signature = CommandNames::DEPOSIT_MONEY;

    /**
     * @var string
     */
    protected $description = 'Deposit money';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param AtmInterface $atm
     * @return int
     */
    public function handle(AtmInterface $atm): int
    {
        $this->info('Insert banknotes one at a time..' . PHP_EOL
            . 'Allowed denominations: ' . implode(', ', $atm->getBanknotesNominals()) . ' rubles.');

        $banknote = (int) $this->ask('Deposited banknote');

        in_array($banknote, $atm->getBanknotesNominals())
            ? $atm->putBanknote(new Banknote($banknote))
            : $this->error('Banknote not recognized');


        $this->confirm('Would you like to put more banknotes?')
            ? $this->call(CommandNames::DEPOSIT_MONEY)
            : $this->call(CommandNames::ATM_MENU);

        return 0;
    }
}
