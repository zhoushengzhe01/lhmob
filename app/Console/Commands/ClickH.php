<?php

namespace App\Console\Commands;

use App\Http\Controllers\Jihua\EarningClickController;
use App\Http\Controllers\Jihua\EarningPvController;
use Illuminate\Console\Command;

class ClickH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clickh';

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
     * @return mixed
     */
    public function handle()
    {
        EarningClickController::EarningHour();
    }
    
}
