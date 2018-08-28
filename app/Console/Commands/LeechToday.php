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

class LeechToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leech_today {start=1} {end=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $typePrize = [
        'giaidb' => 0,
        'giai1' => 1,
        'giai2' => 2,
        'giai3' => 3,
        'giai4' => 4,
        'giai5' => 5,
        'giai6' => 6,
        'giai7' => 7,
        'giai8' => 8,
    ];

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
            $end_date = date('Y-m-d',strtotime("+1 days"));
        }
        ini_set('max_execution_time', -1); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');

        $arr_date = $this->getArrayLoopFromStartDateEndDate($this->parseDate($start_date), $this->parseDate($end_date));

        $provinces = Province::where('type', 'normal')->where('status', 1);
        $provinces = $provinces->get();

        DB::beginTransaction();

        foreach ($provinces as $key => $province) {
            foreach ($arr_date as $item => $date) {
                $this->crawlerDataProvinceDate($province->id, $date);
                echo("Xong lấy kết quả tỉnh =>" . $province->name . " => ngày " . $date . "\n");
            }
            echo "XONG TỈNH =>" . $province->name . "\n";
        }

        DB::commit();

        echo "Hoàn tất \n";
        exit();

    }

    public function crawlerDataProvinceDate($provinceId, $date)
    {
        ini_set('max_execution_time', -1); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.minhngoc.net.vn/tra-cuu-ket-qua-xo-so-tinh.html?tinh=" . $provinceId . "&" . $this->parseQueryFromDate($date));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = "Authority: www.minhngoc.net.vn";
        $headers[] = "Upgrade-Insecure-Requests: 1";
        $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $headers[] = "Referer: https://www.minhngoc.net.vn/tra-cuu-ket-qua-xo-so-tinh.html?tinh=" . $provinceId . "&" . $this->parseQueryFromDate($date);
        $headers[] = "Accept-Encoding: gzip, deflate, br";
        $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
        $headers[] = "Cookie: _ga=GA1.3.521728917.1524540683; _gid=GA1.3.1302351708.1525577429; dnw_vsck=2; __atuvc=1%7C17%2C0%7C18%2C4%7C19; mobile=mobile; _gat_gtag_UA_85565001_1=1";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($result) {
            $province = Province::find($provinceId);
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($result);
            libxml_use_internal_errors($internalErrors);
            $finder = new \DomXPath($dom);
            // query get box
            $listTd = $dom->getElementsByTagName('td');
            if ($listTd) {
                foreach ($listTd as $key => $t) {
                    if
                    (
                        $t->getAttribute('class') == 'giaidb'
                        || $t->getAttribute('class') == 'giai1'
                        || $t->getAttribute('class') == 'giai2'
                        || $t->getAttribute('class') == 'giai3'
                        || $t->getAttribute('class') == 'giai4'
                        || $t->getAttribute('class') == 'giai5'
                        || $t->getAttribute('class') == 'giai6'
                        || $t->getAttribute('class') == 'giai7'
                        || $t->getAttribute('class') == 'giai8'
                    ) {
                        // check exits
                        $resultLottery = ResultLottery::where('result_day', $this->parseDate($date))->where('province_id', $province->id)->first();
                        if (!$resultLottery) {
                            $resultLottery = new ResultLottery();
                            $resultLottery->province_id = $province->id;
                            if ($province->region_id == 2) {
                                $class_name = "loaive_content";
                                $dbs = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
                                if ($dbs && $dbs->item(0)) {
                                    $resultLottery->lotteries_db_content = $dbs->item(0)->nodeValue;
                                }
                            }
                            $resultLottery->result_day = $this->parseDate($date);
                            $resultLottery->save();
                        }
                        $nodes = $t->getElementsByTagName('div');
                        // add new data
                        foreach ($nodes as $i => $node) {
                            if (!LotteryResultDetail::where('result_lottery_id', $resultLottery->id)->where('prize', $this->getTypeFromClass($t->getAttribute('class')))->where('prize_number', $node->nodeValue)->first()) {
                                $resultLotteryDetail = new LotteryResultDetail();
                                $resultLotteryDetail->prize = $this->getTypeFromClass($t->getAttribute('class'));
                                $resultLotteryDetail->prize_number = $node->nodeValue;
                                if ($this->getTypeFromClass($t->getAttribute('class')) == 8) {
                                    $resultLotteryDetail->prize_number_lotto = $node->nodeValue;
                                } else {
                                    $resultLotteryDetail->prize_number_lotto = substr($node->nodeValue, -2);
                                }
                                $resultLotteryDetail->result_lottery_id = $resultLottery->id;
                                $resultLotteryDetail->order = $i;
                                $resultLotteryDetail->status = 1;
                                if($resultLotteryDetail->save()){
                                    $resultLotteryDetail->head_lotto = substr($resultLotteryDetail->prize_number_lotto,0,1);
                                    $resultLotteryDetail->foot_lotto =substr($resultLotteryDetail->prize_number_lotto,1,2);
                                    $resultLotteryDetail->save();
                                }
                                echo("Lưu xong dữ liệu tỉnh  " . $province->name . " ngày " . $date . ' => Giải ' . $t->getAttribute("class") . " => kết quả số : " . $node->nodeValue . " \n");
                            }
                        }
                    }
                }
            }

        }
        return true;
    }

    private function parseQueryFromDate($date)
    {
        $year = date("Y", (strtotime($date)));
        $month = date("m", (strtotime($date)));
        $day = date("d", (strtotime($date)));
        return $query = 'ngay=' . $day . '&thang=' . $month . '&nam=' . $year;
    }

    public function parseDate($date)
    {
        return date("Y-m-d", (strtotime($date)));
    }

    public function getTypeFromClass($className)
    {
        foreach ($this->typePrize as $key => $value) {
            if ($key == $className) {
                return $value;
            }
        }
        return $this->typePrize[0];
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
