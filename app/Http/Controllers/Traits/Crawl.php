<?php

namespace App\Http\Controllers\Traits;

use App\Helpers\Dom\ClassHelpers;
use App\Helpers\Dom\IdHelpers;
use App\Helpers\Dom\TagNameHelpers;
use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait Crawl
{

    protected function getBetweenDateLottoLongerReturn($provinceAlias, $listProvince = null, $numCheck = null, $orderBy = 'DESC')
    {
        $data = Cache::remember('getBetweenDateLottoLongerReturn_' . md5($provinceAlias), env('SHORT_CACHE_EXPIRED', 3600), function () use ($provinceAlias) {
            $data = [];
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/chu-ky");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&numbers=");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/chu-ky";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.1987032038.1527485378; PHPSESSID=t6seit6tf55sgs0hvellm5s8v3; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $data = [];
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tbodys = $dom->getElementsByTagName('tbody');
                if ($tbodys && count($tbodys) > 0) {
                    foreach ($tbodys as $key => $tbody) {
                        if ($tbody->getAttribute('class') == 'center') {
                            $listTrs = $tbody->getElementsByTagName('tr');
                            if ($listTrs) {
                                foreach ($listTrs as $index => $tr) {
                                    $data[$tr->childNodes[0]->nodeValue]['counter']['count'] = $tr->childNodes[1]->nodeValue;
                                    if ($tr->childNodes[2]->getElementsByTagName('a')) {
                                        $data[$tr->childNodes[0]->nodeValue]['counter']['from'] = ($tr->childNodes[2]->getElementsByTagName('a'))[0]->nodeValue;
                                        $data[$tr->childNodes[0]->nodeValue]['counter']['to'] = ($tr->childNodes[2]->getElementsByTagName('a'))[1]->nodeValue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $data;
        });
        return $data;
    }

    public function crawlerMaxGan($province_alias, $start_date, $end_date, $day_count)
    {
        $html = Cache::remember('crawlerMaxGan_' . md5($province_alias), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $start_date, $end_date, $day_count) {
            $data = [];
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/loto-gan");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($start_date) . "&end_date=" . parseDate($start_date) . "&day_count=" . $day_count);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/loto-gan";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=lb9r1as2lumc5bku0tdg7cu035; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                if ($tables && count($tables) > 0) {
                    foreach ($tables as $key => $table) {
                        if ($table->getAttribute('class') == 'table table-condensed table-bordered table-kq-hover') {
                            $data = $table->C14N();
                        }
                    }
                }
            }
            return $data;
        });
        return $html;
    }

    public function crawlStatisticsSpecialLoop($provinceAlias, $begin_date, $end_date, $number)
    {
        return Cache::remember('crawlStatisticsSpecialLoop_' . md5($provinceAlias) . '_' . md5($number) . '_' . $begin_date . $end_date, env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $begin_date, $end_date, $number) {

            $data = [];
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/chu-ky-dan-dac-biet");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&numbers=" . $number);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/chu-ky-dan-dac-biet";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $divs = $dom->getElementsByTagName('div');
                if ($divs && count($divs) > 0) {
                    foreach ($divs as $key => $div) {
                        if ($div->getAttribute('class') == 'kqbackground daudong') {
                            $data = $div->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }

    public function crawlStatisticsLottoLoop($provinceAlias, $begin_date, $end_date, $number)
    {
        return Cache::remember('crawlStatisticsLottoLoop_' . md5($provinceAlias) . '_' . md5($number) . '_' . $begin_date . $end_date, env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $begin_date, $end_date, $number) {

            $data = [];
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/chu-ky-dan-loto");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&numbers=" . $number);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/chu-ky-dan-dac-biet";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $divs = $dom->getElementsByTagName('div');
                if ($divs && count($divs) > 0) {
                    foreach ($divs as $key => $div) {
                        if ($div->getAttribute('class') == 'kqbackground daudong') {
                            $data = $div->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }

    public function crawlMaxDanResults($provinceAlias, $begin_date, $end_date, $number)
    {
        return Cache::remember('crawlMaxDanResults_' . md5($provinceAlias) . '_' . md5($number) . '_' . $begin_date . $end_date, env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $begin_date, $end_date, $number) {

            $data = [];
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/max-dan-cung-ve");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&numbers=" . $number);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/max-dan-cung-ve";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $divs = $dom->getElementsByTagName('div');
                if ($divs && count($divs) > 0) {
                    foreach ($divs as $key => $div) {
                        if ($div->getAttribute('class') == 'kqbackground daudong') {
                            $data = $div->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }

    public function crawlSpecialLottoWeekend($provinceAlias, $begin_date, $end_date)
    {
        return Cache::remember('crawlSpecialLottoWeekend_' . md5($provinceAlias) . '_' . $begin_date . $end_date, env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $begin_date, $end_date) {

            $data = [];
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/bang-dac-biet");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/bang-dac-biet";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                if ($tables && count($tables) > 0) {
                    foreach ($tables as $key => $table) {
                        if ($table->getAttribute('class') == 'table table-bordered table-kq-bold-border table-condensed kqcenter kq-table-hover') {
                            $data = $table->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }

    public function crawlSpecialLottoYear($year)
    {
        return Cache::remember('crawlSpecialLottoYear' . md5($year), env('LONG_CACHE_EXPIRED', 1440), function () use ($year) {

            $data = [];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/bang-dac-biet-nam");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "year=" . intval($year));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/bang-dac-biet-nam";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', '', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                if ($tables && count($tables) > 0) {
                    foreach ($tables as $key => $table) {
                        if ($table->getAttribute('class') == 'table table-bordered table-kq-bold-border table-condensed kqcenter kq-table-hover') {
                            $data = $table->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }

    public function crawlSpecialLottoMonth($year, $month)
    {
        return Cache::remember('crawlSpecialLottoYear' . md5($year) . md5($month), env('LONG_CACHE_EXPIRED', 1440), function () use ($year, $month) {

            $data = [];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/bang-dac-biet-thang");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "year=" . intval($year) . "&month=" . intval($month));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/bang-dac-biet-thang";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', '', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                if ($tables && count($tables) > 0) {
                    foreach ($tables as $key => $table) {
                        if ($table->getAttribute('class') == 'table table-bordered table-kq-bold-border table-condensed kqcenter kq-table-hover') {
                            $data = $table->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }


    public function crawlSpecialTomorrow($provinceAlias, $end_date)
    {
        return Cache::remember('crawlSpecialTomorrow_' . md5($provinceAlias) . '_' . $end_date, env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $end_date) {

            $data = null;
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/giai-db-ngay-mai");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&end_date=" . parseDate($end_date, 'd-m-Y'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/giai-db-ngay-mai";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; yFyErBHzTvwa={%220%22:1%2C%221%22:1%2C%222%22:1%2C%223%22:1%2C%224%22:1%2C%225%22:1%2C%226%22:1%2C%227%22:1%2C%228%22:1%2C%229%22:1%2C%2210%22:1%2C%2211%22:1%2C%2212%22:1%2C%2213%22:1%2C%2214%22:1%2C%2215%22:1%2C%2216%22:1%2C%2217%22:1%2C%2218%22:1%2C%2219%22:1%2C%2220%22:1%2C%2221%22:1%2C%2222%22:1%2C%2223%22:1%2C%2224%22:1%2C%2225%22:1%2C%2226%22:1%2C%2227%22:1%2C%2228%22:1%2C%2229%22:1%2C%2230%22:1%2C%2231%22:1%2C%2232%22:1%2C%2233%22:1%2C%2234%22:1%2C%2235%22:1%2C%2236%22:1%2C%2237%22:1%2C%2238%22:1%2C%2239%22:1%2C%2240%22:1%2C%2241%22:1%2C%2242%22:1%2C%2243%22:1%2C%2244%22:1%2C%2245%22:1%2C%2246%22:1%2C%2247%22:1%2C%2248%22:1%2C%2249%22:1%2C%2250%22:1%2C%2251%22:1%2C%2252%22:1%2C%2253%22:1%2C%2254%22:1%2C%2255%22:1%2C%2256%22:1%2C%2257%22:1%2C%2258%22:1%2C%2259%22:1%2C%2260%22:1%2C%2261%22:1%2C%2262%22:1%2C%2263%22:1%2C%2264%22:1%2C%2265%22:1%2C%2266%22:1%2C%2267%22:1%2C%2268%22:1%2C%2269%22:1%2C%2270%22:1%2C%2271%22:1%2C%2272%22:1%2C%2273%22:1%2C%2274%22:1%2C%2275%22:1%2C%2276%22:1%2C%2277%22:1%2C%2278%22:1%2C%2279%22:1%2C%2280%22:1%2C%2281%22:1%2C%2282%22:1%2C%2283%22:1%2C%2284%22:1%2C%2285%22:1%2C%2286%22:1%2C%2287%22:1%2C%2288%22:1%2C%2289%22:1%2C%2290%22:1%2C%2291%22:1%2C%2292%22:1%2C%2293%22:1%2C%2294%22:1%2C%2295%22:1%2C%2296%22:1%2C%2297%22:1%2C%2298%22:1%2C%2299%22:1}; _gid=GA1.2.511906259.1528024426; Q2G9Z6zdCtNR={%2200-55%22:1%2C%2201-10%22:1%2C%2202-20%22:1%2C%2203-30%22:1%2C%2204-40%22:1%2C%2205-50%22:1%2C%2206-60%22:1%2C%2207-70%22:1%2C%2208-80%22:1%2C%2209-90%22:1%2C%2211-66%22:1%2C%2212-21%22:1%2C%2213-31%22:1%2C%2214-41%22:1%2C%2215-51%22:1%2C%2216-61%22:1%2C%2217-71%22:1%2C%2218-81%22:1%2C%2219-91%22:1%2C%2222-77%22:1%2C%2223-32%22:1%2C%2224-42%22:1%2C%2225-52%22:1%2C%2226-62%22:1%2C%2227-72%22:1%2C%2228-82%22:1%2C%2229-92%22:1%2C%2233-88%22:1%2C%2234-43%22:1%2C%2235-53%22:1%2C%2236-63%22:1%2C%2237-73%22:1%2C%2238-83%22:1%2C%2239-93%22:1%2C%2244-99%22:1%2C%2245-54%22:1%2C%2246-64%22:1%2C%2247-74%22:1%2C%2248-84%22:1%2C%2249-94%22:1%2C%2256-65%22:1%2C%2257-75%22:1%2C%2258-85%22:1%2C%2259-95%22:1%2C%2267-76%22:1%2C%2268-86%22:1%2C%2269-96%22:1%2C%2278-87%22:1%2C%2279-97%22:1%2C%2289-98%22:1}; PHPSESSID=b0bb27c1a8d2e0fd81fa7df942f7051e; __cf_mob_redir=0; _gat=1";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                if ($tables && count($tables) > 0) {
                    foreach ($tables as $key => $table) {
                        if ($table->getAttribute('class') == 'table table-bordered table-condensed qtk-hover-body-only kqcenter table-kq-bold-border kqbackground') {
                            $data .= $table->C14N();
                        }
                    }
                }
            }
            return $data;
        });
    }


    public function crawlInspiredSpecialLotto($province_alias, $end_date, $count, $both_digit = 'off')
    {
        return Cache::remember('crawlInspiredSpecialLotto_' . md5($province_alias) . '_' . $end_date . '_' . md5($count) . md5($both_digit), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $end_date, $count, $both_digit) {

            $data = array(
                'table' => '',
                'popup' => '',
                'row' => '',
                'count' => ''
            );
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/cau-giai-dac-biet");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if ($both_digit == 'on') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&count=" . intval($count) . "&both_digit=on");

            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&count=" . intval($count));

            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/cau-giai-dac-biet";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=g6ajpccun6isu6u30ri9eskkf4; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                // handle table kq
                if ($tables && count($tables) > 0) {
                    $check = 1;
                    foreach ($tables as $key => $item) {
                        if ($item->getAttribute('class') == 'table table-condensed table-bordered kqbackground table-kq-bold-border table-kq-hover kqcenter') {
                            $data['table'] .= $item->C14N();
                            $check = $check + 1;
                        } else {
                            if ($check == 1) {
                                $data['table'] .= '<p class="text-danger">Lỗi: Không có cầu đặc biệt nào trong khoảng ngày bạn đã chọn</p>';
                            }
                            $check = $check + 1;
                        }
                    }
                }
                // handle popup
                $query_tag = new TagNameHelpers('p');
                $nodes = $query_tag->loadHtml($result)->find();
                if ($nodes) {
                    foreach ($nodes as $index_node => $item) {
                        if ($item->getAttribute('class') == 'text-center') {
                            $data['popup'] .= $item->C14N();
                        } elseif ($item->getAttribute('class') == 'max-cau daudong chu15') {
                            $data['count'] = $item->getElementsByTagName('b')[0]->nodeValue;
                        }
                    }
                    $query_id = new IdHelpers('myModal');
                    $nodes = $query_id->loadHtml($result)->find();
                    if ($nodes) {
                        $data['popup'] .= $nodes->C14N();
                    }
                }
                // and popup

                $query_class = new ClassHelpers('row');
                $nodes = $query_class->loadHtml($result)->find();
                for ($i = 7; $i <= 7 + $count; $i++) {
                    $data['row'] .= $nodes[$i]->C14N();
                }
            }
            return $data;
        });
    }

    public function crawlInspiredLottoWithUrl($url, $province_alias, $end_date, $count)
    {
        return Cache::remember('crawlInspiredLotto_' . md5($province_alias) . '_' . $end_date . '_' . md5($count) . md5($url), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $end_date, $count, $url) {

            $data = array(
                'table' => '',
                'popup' => '',
                'row' => '',
                'count' => ''
            );
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&count=" . intval($count));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: " . $url;
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=g6ajpccun6isu6u30ri9eskkf4; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                // handle table kq
                if ($tables && count($tables) > 0) {
                    $check = 1;
                    foreach ($tables as $key => $item) {
                        if ($item->getAttribute('class') == 'table table-condensed table-bordered kqbackground table-kq-bold-border table-kq-hover kqcenter') {
                            $data['table'] .= $item->C14N();
                            $check = $check + 1;
                        } else {
                            if ($check == 1) {
                                $data['table'] .= '<p class="text-danger">Lỗi: Không có dữ liệu nào trong khoảng ngày bạn đã chọn</p>';
                            }
                            $check = $check + 1;
                        }
                    }
                }
                // handle popup
                $query_tag = new TagNameHelpers('p');
                $nodes = $query_tag->loadHtml($result)->find();
                if ($nodes) {
                    foreach ($nodes as $index_node => $item) {
                        if ($item->getAttribute('class') == 'text-center') {
                            $data['popup'] .= $item->C14N();
                        } elseif ($item->getAttribute('class') == 'max-cau daudong chu15') {
                            $data['count'] = $item->getElementsByTagName('b')[0]->nodeValue;
                        }
                    }
                    $query_id = new IdHelpers('myModal');
                    $nodes = $query_id->loadHtml($result)->find();
                    if ($nodes) {
                        $data['popup'] .= $nodes->C14N();
                    }
                }
                // and popup

                $query_class = new ClassHelpers('row');
                $nodes = $query_class->loadHtml($result)->find();
                for ($i = 7; $i <= 7 + $count; $i++) {
                    $data['row'] .= $nodes[$i]->C14N();
                }
            }
            return $data;
        });
    }


    public function crawlViewByDay($url, $province_alias, $day_ow, $count, $both_digit = 'off')
    {
        return Cache::remember('crawlViewByDay_' . md5($province_alias) . '_' . $day_ow . '_' . md5($count) . md5($url), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $day_ow, $count, $url, $both_digit) {

            $data = array(
                'table' => '',
                'popup' => '',
                'row' => '',
                'count' => ''
            );
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if ($both_digit == 'on') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&day_ow=" . $day_ow . "&count=" . intval($count) . '&both_digit=on');
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&day_ow=" . $day_ow . "&count=" . intval($count));
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: " . $url;
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=g6ajpccun6isu6u30ri9eskkf4; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($result);
                libxml_use_internal_errors($internalErrors);
                $tables = $dom->getElementsByTagName('table');
                // handle table kq
                if ($tables && count($tables) > 0) {
                    $check = 1;
                    foreach ($tables as $key => $item) {
                        if ($item->getAttribute('class') == 'table table-condensed table-bordered kqbackground table-kq-bold-border table-kq-hover kqcenter') {
                            $data['table'] .= $item->C14N();
                            $check = $check + 1;
                        } else {
                            if ($check == 1) {
                                $data['table'] .= '<p class="text-danger">Lỗi: Không có dữ liệu nào trong khoảng ngày bạn đã chọn</p>';
                            }
                            $check = $check + 1;
                        }
                    }
                }
                // handle popup
                $query_tag = new TagNameHelpers('p');
                $nodes = $query_tag->loadHtml($result)->find();
                if ($nodes) {
                    foreach ($nodes as $index_node => $item) {
                        if ($item->getAttribute('class') == 'text-center') {
                            $data['popup'] .= $item->C14N();
                        } elseif ($item->getAttribute('class') == 'max-cau daudong chu15') {
                            $data['count'] = $item->getElementsByTagName('b')[0]->nodeValue;
                        }
                    }
                    $query_id = new IdHelpers('myModal');
                    $nodes = $query_id->loadHtml($result)->find();
                    if ($nodes) {
                        $data['popup'] .= $nodes->C14N();
                    }
                }
                // and popup

                $query_class = new ClassHelpers('row');
                $nodes = $query_class->loadHtml($result)->find();
                for ($i = 7; $i <= 7 + $count; $i++) {
                    $data['row'] .= $nodes[$i]->C14N();
                }
            }
            return $data;
        });
    }

    public function crawlSearchHistory($province_alias, $begin_date, $end_date, $bach_thu, $pos_1, $pos_2)
    {
        return Cache::remember('crawlSearchHistory_' . md5($province_alias . '_' . $begin_date . '_' . $end_date . '_' . $pos_1 . '_' . $pos_2 . '_' . $bach_thu), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $begin_date, $end_date, $bach_thu, $pos_1, $pos_2) {
            $data = '';
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/lich-su-cau");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if ($bach_thu == 'on') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&pos_1=" . $pos_1 . "&pos_2=" . $pos_2 . "&bach_thu=on");
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&pos_1=" . $pos_1 . "&pos_2=" . $pos_2);
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/lich-su-cau";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=84mm6ped4orbp0daiakcq74v20; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias .
                    '" data-code="' . $code . '
                 " data-pos_1="' . $pos_1 . '"
                 " data-pos_2="' . $pos_2 . '"
                 " data-begin_date="' . $begin_date . '"
                 " data-end_date="' . $end_date . '"
                 ', $result);
                $tag_query = new TagNameHelpers('table');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    foreach ($tabs as $index => $item) {
                        if ($item->getAttribute('class') == 'table table-condensed table-bordered qtk-hover kqbackground table-kq-bold-border') {
                            $data .= $item->C14N();
                        }
                    }
                }
                $class_query = new ClassHelpers('div-hidden');
                $divs = $class_query->loadHtml($result)->find();
                if ($divs->length > 0) {
                    foreach ($divs as $item) {
                        $data .= $item->C14N();
                    }
                }
            }
            return $data;
        });
    }

    public function crawlViewProvinceCauDetails($province_alias, $begin_date, $end_date, $pos_1, $pos_2)
    {
        return Cache::remember('crawlViewProvinceCauDetails_update_23062018_' . md5($province_alias . '_' . $begin_date . '_' . $end_date . '_' . $pos_1 . '_' . $pos_2), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $begin_date, $end_date, $pos_1, $pos_2) {
            $data = '';
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/view_province_cau_details.php?code=" . $code . "&begin_date=" . parseDate($begin_date, 'd-m-Y') . "&end_date=" . parseDate($end_date, 'd-m-Y') . "&pos1=" . $pos_1 . "&pos2=" . $pos_2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/lich-su-cau";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=84mm6ped4orbp0daiakcq74v20; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias .
                    '" data-code="' . $code . '
                 " data-pos_1="' . $pos_1 . '"
                 " data-pos_2="' . $pos_2 . '"
                 " data-begin_date="' . $begin_date . '"
                 " data-end_date="' . $end_date . '"
                 ', $result);

                $class_query = new ClassHelpers('row');
                $nodes = $class_query->loadHtml($result)->find();
                $limit = countBetweenDateDiff($begin_date, $end_date);
                for ($i = 6; $i <= 6 + $limit; $i++) {
                    if (isset($nodes[$i])) {
                        $data .= $nodes[$i]->C14N();
                    }
                }
            }
            return $data;
        });
    }

    // thong ke nhanh

    public function crawlStatisticsImportant($province_alias, $limit)
    {
        return Cache::remember('crawlStatisticsImportant_' . md5($province_alias . '_' . $limit), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $limit) {
            $data = '';
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/thong-ke-quan-trong");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/thong-ke-quan-trong";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.443024445.1528698482; PHPSESSID=255ubaqlqq622loq1jse0h4pr4; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                //tab 0
                $tag_query = new IdHelpers('bottom10');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    $data .= $tabs->C14N();
                }

                //tab 1
                $tag_query = new IdHelpers('nolast10');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    $data .= $tabs->C14N();
                }
                // tab2
                $tag_query = new IdHelpers('longstreak');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    $data .= $tabs->C14N();
                }
                // tab3
                $tag_query = new IdHelpers('longest_streaks_end_last_day');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    $data .= $tabs->C14N();
                }
            }
            return $data;
        });
    }

    // chu ki dac biet
    public function crawlSpecial($province_alias, $end_date)
    {
        return Cache::remember('crawlSpecial_' . md5($province_alias . '_' . md5($end_date)), env('LONG_CACHE_EXPIRED', 1440), function () use ($province_alias, $end_date) {
            $data = [
                'head' => '',
                'foot' => '',
                'total' => ''
            ];
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/chu-ky-dac-biet");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&end_date=" . $this->parseDate($end_date, 'd-m-Y'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/chu-ky-dac-biet";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.2121948694.1529379735; PHPSESSID=4bqm0ddgts0arkhlc12um5ig90; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                //tab 0
                $tag_query = new ClassHelpers('table table-condensed table-bordered qtk-hover table-kq-bold-border kqbackground');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs) {
                    if (isset($tabs[0])) {
                        $data['head'] .= $tabs[0]->C14N();
                    }
                    if (isset($tabs[1])) {
                        $data['foot'] .= $tabs[1]->C14N();
                    }
                    if (isset($tabs[2])) {
                        $data['total'] .= $tabs[2]->C14N();
                    }
                }
            }
            return $data;
        });
    }

    public function crawlStatisticsByDay($province_alias, $day_of_week, $day_method)
    {
        return Cache::remember('crawlStatisticsByDay_' . md5($province_alias . '_' . md5($day_of_week) . '_' . md5($day_method)), env('HAFT_LONG_CACHE_EXPIRED', 720), function () use ($province_alias, $day_of_week, $day_method) {

            $data = '';
            if ($province_alias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($province_alias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/thong-ke-theo-ngay");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&day_of_week=" . $day_of_week . "&day_method=" . $day_method);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/thong-ke-theo-ngay";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.2121948694.1529379735; PHPSESSID=4bqm0ddgts0arkhlc12um5ig90; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $province_alias . '"', $result);
                $tag_query = new ClassHelpers('kqbackground borderden');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs->length > 0) {
                    foreach ($tabs as $key => $item) {
                        $data .= $item->C14N();
                        $data .= '</br>';
                    }
                }
            }
            return $data;
        });
    }

    public function crawlStatisticsTotalLotto($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only)
    {
        return Cache::remember('crawlStatisticsTotalLotto_' . md5($provinceAlias . '_' . md5($begin_date) . '_' . md5($end_date).md5($special_only).md5(date('d-m-Y'))), env('HAFT_LONG_CACHE_EXPIRED', 720), function () use ($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only) {

            $data = '';
            if ($provinceAlias == 'mien-bac') {
                $code = 'mb';
            } else {
                $province = Province::where('slug', trim($provinceAlias))->first()->toArray();
                $code = $province['alias'];
            }
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/thong-ke-theo-tong");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if (!$special_only || $special_only == 'off') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date) . "&end_date=" . parseDate($end_date));

            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&begin_date=" . parseDate($begin_date) . "&end_date=" . parseDate($end_date) . "&special_only=on");
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = "Connection: keep-alive";
            $headers[] = "Cache-Control: max-age=0";
            $headers[] = "Origin: http://ketqua.net";
            $headers[] = "Upgrade-Insecure-Requests: 1";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36";
            $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $headers[] = "Referer: http://ketqua.net/thong-ke-theo-tong";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: en-US,en;q=0.9,vi;q=0.8,fr;q=0.7";
            $headers[] = "Cookie: __cfduid=d881a8a8e360691f537c7f445e915396c1524551452; _ga=GA1.2.2059095247.1524551454; _gid=GA1.2.776513134.1531405776; PHPSESSID=snavmidb1njeo4eh2aq6no1oa5; __cf_mob_redir=0";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                $result = preg_replace('/(href=.)[^"]+/', 'onclick="Core.openLink(this);" data-province="' . $provinceAlias . '"', $result);
                $tag_query = new ClassHelpers('table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover');
                $tabs = $tag_query->loadHtml($result)->find();
                if ($tabs->length > 0) {
                    foreach ($tabs as $key => $item) {
                        $data .= $item->C14N();
                    }
                }
            }
            return $data;
        });
    }
}