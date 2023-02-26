<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Echo hello world';

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
    public function handle()
    {
        $this->info('Hello world');

        if ($this->confirm('Do you wish to return menu?', true)) {
            $password = $this->secret('Enter password:');
            echo $password . PHP_EOL;
        }

        $availableOperations = [
            'A' => 'ATM balance',
            'B' => 'Show account balance',
            'C' => 'Withdraw',
            'D' => 'Put',
            'E' => 'Logout'
        ];

        $defaultIndex = 'E';

        $operation = $this->choice(
            'Choose an operation?',
            $availableOperations,
            $defaultIndex,
            $maxAttempts = 3,
            $allowMultipleSelections = false
        );

        echo '$operation: ';
        var_dump($operation);

        $this->info('The command was successful!');
        $this->error('Something went wrong!');
        $this->line('Display this on the screen');
        $this->newLine(3);
        $this->warn('Warn warn went wrong!');
        $this->line('Question?');

        $this->table(
            ['Name', 'Email'],
            [
                ['Vasya', 'aa@bb.ru'],
                ['gdsssssssssssss', 'aa@bb.ru'],
                ['Vasya', 'aadfsf@bbsss.ru'],
                ['Vasyasfsf', 'ggaa@bb.rsu'],
            ]
        );

    }
}
