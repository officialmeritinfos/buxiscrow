<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createCustomerSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:customerSystem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a customer ';

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
        return Command::SUCCESS;
    }
}
