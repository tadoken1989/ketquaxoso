<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LotteryResultDetail;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Leech123 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leech_123 {start=1} {end=1}';

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
        $start_date = $this->argument('start');
        $end_date = $this->argument('end');
        if ($start_date == 1 && $end_date == 1) {
            echo "Will crawler with today \n";
            $start_date = date('Y-m-d',strtotime("-1 days"));
            $end_date = date('Y-m-d');
        }
        ini_set('max_execution_time', -1); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');

        $arr_date = $this->getArrayLoopFromStartDateEndDate($this->parseDate($start_date), $this->parseDate($end_date));

        // task 1

        echo "BẮT ĐẦU  => điện toán 123 \n";

        try {
            DB::beginTransaction();

            foreach ($arr_date as $item => $date) {
                $this->crawler($date);
                echo("Xong lấy kết quả điện toán 123 ngày " . $date . "\n");
            }
            echo "XONG TỈNH => điện toán 123 \n";

            DB::commit();

            DB::commit();
        } catch (\Exception $ex) {

        }
        echo "......................................... \n";
        echo "BẮT ĐẦU  => thần tài \n";
        try {
            DB::beginTransaction();

            foreach ($arr_date as $item => $date) {
                $this->crawler_2($date);
                echo("Xong lấy kết quả thần tài ngày " . $date . "\n");
            }

            DB::commit();
        } catch (\Exception $ex) {

        }


        echo "......................................... \n";
        echo "BẮT ĐẦU  => 6X36 \n";
        try {
            DB::beginTransaction();

            foreach ($arr_date as $item => $date) {
                $this->crawler_3($date);
                echo("Xong lấy kết quả 6X36 ngày " . $date . "\n");
            }

            DB::commit();
        } catch (\Exception $ex) {

        }

        echo "Hoàn tất \n";
        exit();

    }


    public function crawler($date)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/xo-so-dien-toan-123.php?ngay=" . $this->parseDateQuery($date));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = "Connection: keep-alive";
        $headers[] = "Cache-Control: max-age=0";
        $headers[] = "Upgrade-Insecure-Requests: 1";
        $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $headers[] = "Accept-Encoding: gzip, deflate";
        $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
        $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; PHPSESSID=282trvgu2e590h9husl5duelo1; _gid=GA1.2.1764420546.1526530489; __cf_mob_redir=0; docookie=node-12885395|Wv0rR|Wv0rA";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $provinceId = 60;// dien-toan-123
        if ($result) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($result);
            libxml_use_internal_errors($internalErrors);
            $table = $dom->getElementById('result_tab_123');
            $trs = null;
            if ($table) {
                $trs = $table->getElementsByTagName('tr');
            }
            if ($table && $trs) {
                $province = Province::find($provinceId);
                $resultLottery = ResultLottery::where('result_day', $this->parseDate($date))->where('province_id', $province->id)->first();
                if (!$resultLottery) {
                    $resultLottery = new ResultLottery();
                    $resultLottery->province_id = $province->id;
                    $resultLottery->type = '123';
                    $resultLottery->result_day = $this->parseDate($date);
                    $resultLottery->save();
                }
                foreach ($trs as $key => $tr) {
                    if ($tr->getAttribute('class') != 'title_row') {
                        $tds = $tr->getElementsByTagName('td');
                        foreach ($tds as $i => $item) {
                            if (!LotteryResultDetail::where('result_lottery_id', $resultLottery->id)->where('prize_number', $item->nodeValue)->first()) {
                                $resultLotteryDetail = new LotteryResultDetail();
                                $resultLotteryDetail->prize = 1;
                                $resultLotteryDetail->prize_number = $item->nodeValue;
                                $resultLotteryDetail->prize_number_lotto = substr($item->nodeValue,-2);
                                $resultLotteryDetail->result_lottery_id = $resultLottery->id;
                                $resultLotteryDetail->order = $i;
                                $resultLotteryDetail->status = 1;
                                $resultLotteryDetail->save();
                                echo("Lưu xong dữ liệu  " . $province->name . "=> ngày " . $date . ' => Giải ' . $i . " => kết quả số : " . $item->nodeValue . " \n");
                            }
                        }
                    }
                }
            }

        }
        return true;
    }


    public function crawler_2($date)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/xo-so-than-tai.php?ngay=" . $this->parseDateQuery($date));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = "Connection: keep-alive";
        $headers[] = "Cache-Control: max-age=0";
        $headers[] = "Upgrade-Insecure-Requests: 1";
        $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $headers[] = "Accept-Encoding: gzip, deflate";
        $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
        $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; PHPSESSID=282trvgu2e590h9husl5duelo1; _gid=GA1.2.1764420546.1526530489; __cf_mob_redir=0; docookie=node-12885395|Wv0rR|Wv0rA";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $provinceId = 62;// than-tai 62
        if ($result) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($result);
            libxml_use_internal_errors($internalErrors);
            $item = $dom->getElementById('rs_0_0');
            if ($item) {
                $province = Province::find($provinceId);
                $resultLottery = ResultLottery::where('result_day', $this->parseDate($date))->where('province_id', $province->id)->first();
                if (!$resultLottery) {
                    $resultLottery = new ResultLottery();
                    $resultLottery->province_id = $province->id;
                    $resultLottery->type = 'than-tai';
                    $resultLottery->result_day = $this->parseDate($date);
                    $resultLottery->save();
                }
                if (!LotteryResultDetail::where('result_lottery_id', $resultLottery->id)->where('prize_number', $item->nodeValue)->first()) {
                    $resultLotteryDetail = new LotteryResultDetail();
                    $resultLotteryDetail->prize = 1;
                    $resultLotteryDetail->prize_number = $item->nodeValue;
                    $resultLotteryDetail->prize_number_lotto = substr($item->nodeValue,-2);
                    $resultLotteryDetail->result_lottery_id = $resultLottery->id;
                    $resultLotteryDetail->order = 0;
                    $resultLotteryDetail->status = 1;
                    $resultLotteryDetail->save();
                    echo("Lưu xong dữ liệu  " . $province->name . "=> ngày " . $date . ' => Giải ' . 1 . " => kết quả số : " . $item->nodeValue . " \n");
                }
            }
        }
        return true;
    }

    public function crawler_3($date)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/xo-so-dien-toan-6x36.php?ngay=" . $this->parseDateQuery($date));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = "Connection: keep-alive";
        $headers[] = "Cache-Control: max-age=0";
        $headers[] = "Upgrade-Insecure-Requests: 1";
        $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $headers[] = "Accept-Encoding: gzip, deflate";
        $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
        $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; PHPSESSID=282trvgu2e590h9husl5duelo1; _gid=GA1.2.1764420546.1526530489; __cf_mob_redir=0; docookie=node-12885395|Wv0rR|Wv0rA";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $provinceId = 61;// 636
        if ($result) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($result);
            libxml_use_internal_errors($internalErrors);
            $table = $dom->getElementById('result_tab_636');
            if ($table) {
                $trs = $table->getElementsByTagName('tr');
                if ($table && $trs) {
                    $province = Province::find($provinceId);
                    $resultLottery = ResultLottery::where('result_day', $this->parseDate($date))->where('province_id', $province->id)->first();
                    if (!$resultLottery) {
                        $resultLottery = new ResultLottery();
                        $resultLottery->province_id = $province->id;
                        $resultLottery->type = '6-36';
                        $resultLottery->result_day = $this->parseDate($date);
                        $resultLottery->save();
                    }
                    foreach ($trs as $key => $tr) {
                        if ($tr->getAttribute('class') != 'title_row') {
                            $tds = $tr->getElementsByTagName('td');
                            foreach ($tds as $i => $item) {
                                if (!LotteryResultDetail::where('result_lottery_id', $resultLottery->id)->where('prize_number', $item->nodeValue)->first()) {
                                    $resultLotteryDetail = new LotteryResultDetail();
                                    $resultLotteryDetail->prize = 1;
                                    $resultLotteryDetail->prize_number = $item->nodeValue;
                                    $resultLotteryDetail->prize_number_lotto = substr($item->nodeValue,-2);
                                    $resultLotteryDetail->result_lottery_id = $resultLottery->id;
                                    $resultLotteryDetail->order = $i;
                                    $resultLotteryDetail->status = 1;
                                    $resultLotteryDetail->save();
                                    echo("Lưu xong dữ liệu  " . $province->name . "=> ngày " . $date . ' => Giải ' . $i . " => kết quả số : " . $item->nodeValue . " \n");
                                }
                            }
                        }
                    }
                }
            } else {
                echo "Result of Điện Toán 6x36 for " . $date . " is not available! \n";
            }
        }
        return true;
    }


    public function parseDate($date)
    {
        return date("Y-m-d", (strtotime($date)));
    }

    public function parseDateQuery($date)
    {
        return date("d-m-Y", (strtotime($date)));
    }

    private function getArrayLoopFromStartDateEndDate($start, $end)
    {
        $begin = new \DateTime($start);
        $end = new \DateTime($end);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $array = [];
        foreach ($period as $dt) {
            array_push($array, $dt->format("Y-m-d"));
        }
        return $array;
    }
}
