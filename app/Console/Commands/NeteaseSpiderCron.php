<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Http\Controllers\NeteaseController;
class NeteaseSpiderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NeteaseSpider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this is a Netease Spider';

    /**
     * Create a new command instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        parent::__construct();
//        Log::info('NeteaseSpider start');
//    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Log::info('NeteaseSpider start');
        $netease = new NeteaseController();
        $netease->getNewsByType("main",0);
    }
}
