<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use Illuminate\Console\Command;

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
    public function handle(AtmInterface $atm): int
    {
        $withdrawalAmount = (int) $this->ask('How much do you want to withdraw?');

        if (!$atm->isEnoughSumInAccount($withdrawalAmount)) {
            $this->warn('Insufficient funds on the account');
        }

        if (!$atm->isEnoughSumInAtm($withdrawalAmount)) {
            $this->warn('Insufficient funds at the ATM');
        }



        $this->confirm('Want to withdraw more money?')
            ? $this->call(CommandNames::DEPOSIT_MONEY)
            : $this->call(CommandNames::ATM_MENU);

        return 0;
    }
}

