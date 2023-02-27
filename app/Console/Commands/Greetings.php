<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\CashBox;
use App\Services\Interfaces\AtmInterface;
use App\Services\Interfaces\CashBoxInterface;
use Illuminate\Console\Command;
use WS\Utils\Collections\Collection;

class Greetings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::ATM_GREETINGS;

    /**
     * @var string
     */
    protected $description = 'Starting greeting';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(CashBoxInterface $cashBox): int
    {
        $this->info('Welcome');

        return 0;
    }
}
