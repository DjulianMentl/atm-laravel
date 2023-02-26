<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use App\Services\Interfaces\AtmInterface;
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
    public function handle(AtmInterface $atm): int
    {
        $this->info('Welcome');

        $atm->firstCollection();
        return 0;
    }
}
