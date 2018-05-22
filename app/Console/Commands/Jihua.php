<?php

namespace App\Console\Commands;

use App\Http\Controllers\Jihua\EarningClickController;
use App\Http\Controllers\Jihua\EarningPvController;
use Illuminate\Console\Command;

class Jihua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jihua';

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
        $message = "请输入你想执行的操作 ? \n\n";

        $message .= "    cm：分钟点击结算. \n\n";
        $message .= "    ch：小时点击结算. \n\n";
        $message .= "    cd：每天点击结算. \n\n\n";

        $message .= "    vm：分钟点击结算. \n\n";
        $message .= "    vh：小时点击结算. \n\n";
        $message .= "    vd：每天点击结算. \n\n";

        $type = $this->ask($message);

        if($type=="cm")
        {
            EarningClickController::EarningMinute();
        }
        if($type=="ch")
        {
            EarningClickController::EarningHour();
        }
        if($type=="cd")
        {
            EarningClickController::EarningDay();
        }

        if($type=="vm")
        {
            EarningPvController::EarningMinute();
        }
        if($type=="vh")
        {
            EarningPvController::EarningHour();
        }
        if($type=="vd")
        {
            EarningPvController::EarningDay();
        }

    }
    
}
