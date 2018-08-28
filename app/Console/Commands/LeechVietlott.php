<?php

namespace App\Console\Commands;

use App\Helpers\VietlottCrawler;
use Illuminate\Console\Command;

class LeechVietlott extends Command
{
    /**
     * The name and signature of the console command.
     * date: today , range
     * type: mega, power, max4d
     * from: date_from 20170101
     * to: date_to 20180822
     * @var string
     */
    protected $signature = 'leech_vietlott {type} {from=now} {to?}';

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

        $type = $this->argument('type');
        $from = $this->argument('from');
        $to = $this->argument('to');
        \Log::info("LeecgVietlott type=$type from=$from to=$to");

        $crawler = new VietlottCrawler();
        if ($type == 'all'){
            foreach([VietlottCrawler::TYPE_MEGA,VietlottCrawler::TYPE_POWER,VietlottCrawler::TYPE_MAX4D] as $type){
                $crawler->crawl($type, $from, $to);
            }
        }else{
            $crawler->crawl($type, $from, $to);
        }

    }


}
