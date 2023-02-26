<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\SessionInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class AtmOperations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::ATM_MENU;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Available operations';

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

        $operation = $this->choice(
            'Choose an operation?',
            $atm->getMenu(),
        );

        $nextCommand = $atm->getCommand($operation);

        $this->call($nextCommand);

        return 0;
    }
}
