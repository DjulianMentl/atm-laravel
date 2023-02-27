<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use Illuminate\Console\Command;
use WS\Utils\Collections\Functions\Comparators;

class Withdraw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::WITHDRAW_MONEY;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Withdraw';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AtmInterface $atm, $message = 'How much do you want to withdraw?'): int
    {

        $withdrawalAmount = (int) $this->ask($message);

        if (!$atm->isMultipleFifty($withdrawalAmount)) {
            $this->warn('The amount is not a multiple of 50');
            return $this->handle($atm, 'Enter the amount in multiples of 50');
        }

        if (!$atm->isEnoughSumInAccount($withdrawalAmount)) {
            $this->warn('Insufficient funds on the account');
            return $this->handle($atm, 'Enter an amount not exceeding: ' . $atm->getActiveSessionBalance());
        }

        if (!$atm->isEnoughSumInAtm($withdrawalAmount)) {
            $this->warn('Insufficient funds at the ATM');
            return $this->handle($atm, 'Enter an amount not exceeding ' . $atm->getAmountOfMoney());
        }

        try {
            $takeSum = $atm->takeBanknotesBySum($withdrawalAmount);

            $takeSum->stream()->each(function ($banknote) {
                $this->info($banknote);
            });
        } catch (\Exception $e) {
            $this->warn('There are no banknotes in the ATM to issue the entered amount');
            $this->info('Enter a different amount');
        }

        $this->call(CommandNames::ATM_MENU);

        return 0;
    }
}

