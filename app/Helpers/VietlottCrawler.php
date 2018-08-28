<?php
/**
 * Created by PhpStorm.
 * User: dauvet-pc
 * Date: 8/23/2018
 * Time: 12:30 PM
 */

namespace App\Helpers;


use App\Models\LotteryResultDetail;
use App\Models\Province;
use App\Models\ResultLottery;
use DB;

class VietlottCrawler
{
    const TYPE_MEGA = 'mega';
    const TYPE_POWER = 'power';
    const TYPE_MAX4D = 'max4d';

    protected $configs = [
        self::TYPE_MEGA => [
            'name' => 'mega',
            'start' => '2017-01-01',
            'days' => [3, 5, 0], // 4 , 6, cn
            'url' => 'https://www.minhngoc.net.vn/ket-qua-xo-so/dien-toan-vietlott/mega-6x45/%s-%s-%s.html'
        ],
        self::TYPE_POWER => [
            'name' => 'power',
            'start' => '2017-08-01',
            'days' => [2, 4, 6], // 3, 5, 7
            'url' => 'https://www.minhngoc.net.vn/ket-qua-xo-so/dien-toan-vietlott/power-6x55/%s-%s-%s.html'
        ],
        self::TYPE_MAX4D => [
            'name' => 'max4d',
            'start' => '2017-01-03',
            'days' => [2, 4, 6], // 3, 5, 7
            'url' => 'https://www.minhngoc.net.vn/ket-qua-xo-so/dien-toan-vietlott/max-4d/%s-%s-%s.html'
        ],
    ];

    /**
     * @param $type: TYPE_MEGA, TYPE_POWER, TYPE_MAX4D
     * @param $from: start, now, [date with format YYYY/mm/dd]
     * @param $to: now, [date with format YYYY/mm/dd]
     */
    public function crawl($type, $from = 'now', $to = ''){
        \Log::info("Start crawl type=$type from=$from to=$to");
        ini_set('max_execution_time', -1); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');
        echo_now("== START crawl type=$type from=$from to=$to at " . date('Y/m/d h:i:s'));

        if ((!$from && !$to) || !in_array($type, [self::TYPE_MEGA,self::TYPE_POWER,self::TYPE_MAX4D])){
            return false;
        }

        if (!$from){
            $from = $to;
        }elseif(!$to){
            $to = $from;
        }

        if ($from == 'start'){
            $from = $this->configs[$type]['start'];
        }elseif ($from == 'now'){
            $from = date('Y-m-d');
        }

        if(strtotime($from) < strtotime($this->configs[$type]['start'])){
            $from = $this->configs[$type]['start'];
        }

        if ($to == 'now'){
            $to = date('Y-m-d');
        }elseif(strtotime($from)>strtotime($to)){
            $to = $from;
        }

        // generate urls
        $urls = [];
        $days = $this->configs[$type]['days'];
        $pattern = $this->configs[$type]['url'];

        $fromTime = strtotime($from);
        $from = date('Y-m-d', $fromTime);
        $to = date('Y-m-d', strtotime($to));

        while($from<=$to){
            $w = date('w',$fromTime);

            // check valids
            $found = array_search($w, $days);
            if ($found !== false){
                $y = date('Y', $fromTime);
                $m = date('m', $fromTime);
                $d = date('d', $fromTime);
                $urls[$from] = sprintf($pattern,$d , $m, $y);

                if ($found>=count($days)-1){
                    $next = 0;
                }else{
                    $next = $found + 1;
                }
                $dayCount = $days[$next] - $days[$found];
                if ($dayCount<0) $dayCount += 7;
                $fromTime = strtotime('+' . $dayCount . ' days', $fromTime);
            }else{
                $fromTime = strtotime('+1 day', $fromTime);
            }

            $from = date('Y-m-d', $fromTime);
        }

        DB::beginTransaction();
        global $parseType, $parseDate, $parseUrl;
        $parseType = $type;

        foreach($urls as $url){
            $parseUrl = $url;

            echo_now('url: ' . $url);

            $ch = curl_init($url);
            curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => TRUE));
            $content = curl_exec($ch);
            curl_close($ch);


            $valid = preg_match('/([0-9]{2})-([0-9]{2})-([0-9]{4}).html/', $url, $matches);
            if ($valid){
                $date = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                $parseDate = $date;
                $data = $this->parseContent($type, $content, $date);

                $this->addData($data);
            }

            echo_now('done: ' . $date . ' - ' . $url);
        }
        DB::commit();
        echo_now('== END crawl type=' . $type . ' at ' . date('Y/m/d'));
        \Log::info("End crawl type=$type");
    }

    public function addData($data){
        if ($data){
            $resultLottery = ResultLottery::where('result_day', $data['result_day'])->where('province_id', $data['province_id'])->first();
            if (!$resultLottery) {
                $resultLottery = new ResultLottery();
                $resultLottery->province_id = $data['province_id'];
                $resultLottery->result_day = $data['result_day'];
                $resultLottery->lotteries_db_content = $data['lotteries_db_content'];
                $resultLottery->save();
            }

            foreach ($data['details'] as $detail) {
                if (!LotteryResultDetail::where('result_lottery_id', $resultLottery->id)->where('prize', $detail['prize'])->where('prize_number', $detail['prize_number'])->first()) {
                    $resultLotteryDetail = new LotteryResultDetail();
                    $resultLotteryDetail->prize = $detail['prize'];
                    $resultLotteryDetail->prize_number = $detail['prize_number'];
                    $resultLotteryDetail->result_lottery_id = $resultLottery->id;
                    $resultLotteryDetail->order = $detail['order'];
                    $resultLotteryDetail->status = 1;
                    $resultLotteryDetail->save();
                }
            }
        }
    }


    function parseContent($type, $content, $date){
        $result = [];
        if ($type == self::TYPE_MEGA){
            $result = $this->parseContentMega($content);
        }elseif ($type == self::TYPE_POWER){
            $result = $this->parseContentPower($content);
        }elseif ($type == self::TYPE_MAX4D){
            $result = $this->parseContentMax4d($content);
        }

        if ($result){
            $province = Province::where('alias', $type)->first();
            $result['result_day'] = $date;
            $result['province_id'] =  $province->id;
        }

        return $result;
    }

    function parseContentMega($content){
        global $parseType, $parseDate, $parseUrl;
        $result = [];

        $s1 = '<div class="boxkqxsdientoan">';
        $s2 = '<div class="bangkqxs_link">';
        $f1 = strpos($content, $s1);
        if ($f1 !== false){
            $f2 = strpos($content, $s2, $f1);
            if ($f2 !== false){
                // found
                $html = substr($content, $f1,$f2 - $f1);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                libxml_use_internal_errors(true);
                //$internalErrors = libxml_use_internal_errors(true);
                if ($dom->loadHTML($html)){
                    \Log::info("=> parseContent type=$parseType date=$parseDate url=$parseUrl");
                    //libxml_use_internal_errors($internalErrors);
                    $finder = new \DomXPath($dom);

                    $patch = $dom->getElementById('DT6X45_KY_VE')->textContent;
                    $resultNumber = remove_trash_chars($finder->query('//ul[contains(@class,"result-number")]')[0]->textContent);
                    $table = $finder->query('//table[contains(@class,"table")]/tbody')[0];
                    $trs = $table->getElementsByTagName('tr');
                    $lotteries_db_content['patch'] = $patch;
                    $lotteries_db_content['result'] = $resultNumber;

                    $prizes = [];

                    foreach($trs as $tr){
                        $tds = $tr->getElementsByTagName('td');
                        array_push($prizes, [
                            'win_count' => str_to_number($tds[2]->textContent),
                            'prize' => str_to_number($tds[3]->textContent),
                        ]);
                    }

                    $lotteries_db_content['prizes'] = $prizes;
                    $result['lotteries_db_content'] = json_encode($lotteries_db_content);
                    $result['details'] = [];
                    $details = str_split($resultNumber, 2);

                    foreach($details as $idx=>$number){
                        array_push($result['details'], [
                            'prize' => 0,
                            'prize_number' => $number,
                            'order' => $idx
                        ]);
                    }
                }else{
                    \Log::info("=> [Error]parseContent type=$parseType date=$parseDate url=$parseUrl");
                }
            }
        }

        return $result;
    }

    function parseContentPower($content){
        global $parseType, $parseDate, $parseUrl;
        $result = [];

        $s1 = '<div class="boxkqxsdientoan">';
        $s2 = '<div class="bangkqxs_link">';
        $f1 = strpos($content, $s1);
        if ($f1 !== false){
            $f2 = strpos($content, $s2, $f1);
            if ($f2 !== false){
                // found
                $html = substr($content, $f1,$f2 - $f1);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                //$internalErrors = libxml_use_internal_errors(true);
                libxml_use_internal_errors(true);
                if ($dom->loadHTML($html)){
                    \Log::info("=> parseContent type=$parseType date=$parseDate url=$parseUrl");
                    //libxml_use_internal_errors($internalErrors);
                    $finder = new \DomXPath($dom);

                    $patch = $dom->getElementById('DT6X45_KY_VE')->textContent;
                    $resultNumber = remove_trash_chars($finder->query('//ul[contains(@class,"result-number")]')[0]->textContent);
                    $table = $finder->query('//table[contains(@class,"table")]/tbody')[0];
                    $trs = $table->getElementsByTagName('tr');
                    $lotteries_db_content['patch'] = $patch;
                    $lotteries_db_content['result'] = $resultNumber;

                    $prizes = [];

                    foreach($trs as $tr){
                        $tds = $tr->getElementsByTagName('td');
                        array_push($prizes, [
                            'win_count' => str_to_number($tds[2]->textContent),
                            'prize' => str_to_number($tds[3]->textContent),
                        ]);
                    }

                    $lotteries_db_content['prizes'] = $prizes;
                    $result['lotteries_db_content'] = json_encode($lotteries_db_content);
                    $result['details'] = [];
                    $details = str_split($resultNumber, 2);

                    foreach($details as $idx=>$number){
                        array_push($result['details'], [
                            'prize' => 0,
                            'prize_number' => $number,
                            'order' => $idx
                        ]);
                    }
                }else{
                    \Log::info("=> parseContent type=$parseType date=$parseDate url=$parseUrl");
                }

            }
        }

        return $result;
    }


    function parseContentMax4d($content){
        global $parseType, $parseDate, $parseUrl;
        $result = [];

        $s1 = '<div class="boxkqxsdientoan">';
        $s2 = '<div class="bangkqxs_link">';
        $f1 = strpos($content, $s1);
        if ($f1 !== false){
            $f2 = strpos($content, $s2, $f1);
            if ($f2 !== false){
                // found
                $html = substr($content, $f1,$f2 - $f1);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                //$internalErrors = libxml_use_internal_errors(true);
                libxml_use_internal_errors(true);
                if ($dom->loadHTML($html)){
                    \Log::info("=> parseContent type=$parseType date=$parseDate url=$parseUrl");
                    //libxml_use_internal_errors($internalErrors);
                    $finder = new \DomXPath($dom);

                    $patch = $dom->getElementById('DTMAX4D_KYVE')->textContent;

                    $table = $finder->query('//table[contains(@class,"table")]/tbody')[0];
                    $trs = $table->getElementsByTagName('tr');
                    $lotteries_db_content['patch'] = $patch;

                    $prizes = [];

                    foreach($trs as $tr){
                        $tds = $tr->getElementsByTagName('td');
                        $results = [];
                        foreach($tds[1]->getElementsByTagName('li') as $li){
                            array_push($results, $li->getElementsByTagName('div')[0]->textContent);
                        }
                        array_push($prizes, [
                            'win_count' => str_to_number($tds[2]->textContent),
                            'prize' => str_to_number($tds[0]->getElementsByTagName('div')[0]->textContent),
                            'results' => $results,
                        ]);
                    }

                    $lotteries_db_content['prizes'] = $prizes;
                    $result['lotteries_db_content'] = json_encode($lotteries_db_content);
                    $result['details'] = [];

                    foreach($prizes as $prize){
                        foreach($prize['results'] as $idx=>$res){
                            array_push($result['details'], [
                                'prize' => $prize['prize'],
                                'prize_number' => $res,
                                'order' => $idx
                            ]);
                        }
                    }
                }else{
                    \Log::info("=> parseContent type=$parseType date=$parseDate url=$parseUrl");
                }
            }
        }

        return $result;
    }

    public static function getRecentResults($type, $province_id = '', $limit = 5){
        if (!$province_id) $province_id = Province::where('alias', $type)->pluck('id')->first();
        return ResultLottery::with(['resultsDetail'])
            ->where('province_id', $province_id)
            ->where('status', 1)
            ->limit($limit)
            ->orderBy('result_day', 'DESC')
            ->get();
    }

    public static function getBestPeriodNumbers($type, $province_id = '', $period = 20, $setNumber = 12){
        $results = [];
        if (!$province_id) $province_id = Province::where('alias', $type)->pluck('id')->first();
        $resultIDs = ResultLottery::where('province_id', $province_id)
            ->where('status', 1)
            ->limit($period)
            ->orderBy('result_day', 'DESC')
            ->pluck('id')
            ->toArray();
        if ($resultIDs){
            $results = DB::table('lottery_result_details')
                ->whereIn('result_lottery_id', $resultIDs)
                ->groupBy('prize_number')
                ->select('prize_number', DB::raw('count(*) as count'))
                ->orderBy('count', 'DESC')
                ->limit($setNumber)
                ->get();
        }

        return $results;
    }

    public static function getWorstNumbers($type, $province_id = '', $period = 20, $setNumber = 12){
        $results = [];
        if (!$province_id) $province_id = Province::where('alias', $type)->pluck('id')->first();
        $resultIDs = ResultLottery::where('province_id', $province_id)
            ->where('status', 1)
            ->limit($period)
            ->orderBy('result_day', 'DESC')
            ->pluck('id')
            ->toArray();
        if ($resultIDs){
            $results = DB::table('lottery_result_details')
                ->whereIn('result_lottery_id', $resultIDs)
                ->groupBy('prize_number')
                ->select('prize_number', DB::raw('count(*) as count'))
                ->orderBy('count', 'ASC')
                ->limit($setNumber)
                ->get();
        }

        return $results;
    }
}