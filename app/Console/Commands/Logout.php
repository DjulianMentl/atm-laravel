<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use Illuminate\Console\Command;

class Logout extends Command
{
    /**
     * @var string
     */
    protected $signature = CommandNames::ATM_LOGOUT;

    /**
     * @var string
     */
    protected $description = 'Logout';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(AtmInterface $atm)
    {
        $this->info('Goodbye ' . $atm->getSessionUserName());

        $atm->logout();
    }
}
