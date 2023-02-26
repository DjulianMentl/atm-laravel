<?php

namespace App\Console\Commands;

use App\DTO\CommandNames;
use Illuminate\Console\Command;

class Executor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = CommandNames::ATM_RUN;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(): int
    {
        $this->call(CommandNames::ATM_GREETINGS);
        $this->call(CommandNames::ATM_USER_AUTH);
        $this->call(CommandNames::ATM_MENU);
        return 0;
    }
}
