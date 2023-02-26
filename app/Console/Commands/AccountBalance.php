<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\DTO\Users;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\SessionInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class AccountBalance extends Command
{
    /**
     * @var string
     */
    protected $signature = CommandNames::CHECK_ACCOUNT_BALANCE;

    /**
     * @var string
     */
    protected $description = 'Show account balance';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle(AtmInterface $atm): int
    {
        $this->info('Account balance:');

        if (!$atm->isSessionActive()) {
            $this->error('Session error');
            exit;
        }

        $this->newLine(1);
        $this->info($atm->getActiveSessionBalance());
        $this->newLine(2);

        $this->call(CommandNames::ATM_MENU);

        return 0;
    }
}
