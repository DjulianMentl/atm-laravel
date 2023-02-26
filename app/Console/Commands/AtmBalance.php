<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class AtmBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::CHECK_ATM_BALANCE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show ATM balance';

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
        $this->info('ATM balance:');

        if (!$atm->isSessionActive()) {
            $this->error('Session error');
            exit;
        }

        $this->newLine(1);
        $this->info($atm->getAmountOfMoney());
        $this->newLine(2);

        $this->call(CommandNames::ATM_MENU);

        return 0;
    }
}
