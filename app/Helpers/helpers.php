<?php

if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return request()->url() == route($route) ? ' class=current' : '';
    }
}

if (!function_exists('currentRouteBootstrap')) {
    function currentRouteBootstrap($route)
    {
        return request()->url() == route($route) ? ' class=active' : '';
    }
}

if (!function_exists('currentRouteCheck')) {
    function currentRouteCheck($url)
    {
        return request()->url() == $url ? 'style=background-color:#fff;color:#ed1d27;font-weight:bold;' : '';
    }
}

if (!function_exists('currentRouteCheckMenu')) {
    function currentRouteCheckMenu($url)
    {
        return request()->url() == $url ? 'class=active' : '';
    }
}

if (!function_exists('user')) {
    function user($id)
    {
        return \App\Models\User::findOrFail($id);
    }
}

if (!function_exists('locales')) {
    function locales()
    {
        $file = resolve(\Illuminate\Filesystem\Filesystem::class);
        $locales = [];
        $results = $file->directories(resource_path('lang'));
        foreach ($results as $result) {
            $name = $file->name($result);
            if ($name !== 'vendor') {
                $locales[$name] = $name;
            }
        }
        return $locales;
    }
}

if (!function_exists('timezones')) {
    function timezones()
    {
        $zones_array = [];
        $timestamp = time();
        foreach (timezone_identifiers_list() as $zone) {
            date_default_timezone_set($zone);
            $zones_array[$zone] = 'UTC' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

if (!function_exists('setTabActive')) {
    function setTabActive()
    {
        return request()->has('page') ? request('page') : 1;
    }
}

if (!function_exists('thumb')) {
    function thumb($url)
    {
        return \App\Services\Thumb::makeThumbPath($url);
    }
}

if (!function_exists('load_menu')) {
    function load_menu()
    {
        return Cache::remember('menu', env('LONG_CACHE_EXPIRED', 1440), function () {
            $all = \App\Models\Menu::where('status', 1)->get()->toArray();
            return buildTree($all);
        });
    }
}

if (!function_exists('col_span')) {
    function col_span()
    {
        return Cache::remember('col_span', env('VERY_LONG_CACHE_EXPIRED', 10080), function () {
            return 12;
        });
    }
}

function buildTree(array $elements, $parentId = 0, $parent_id_field = 'parent_id')
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element[$parent_id_field] == $parentId) {
            $children = buildTree($elements, $element['id']);
            $element['children'] = empty($children) ? [] : $children;

            $branch[] = $element;
        }
    }

    return $branch;
}

function parseStringToDate($date)
{
    $day = date('l', strtotime($date));
    $day = convert_to_vn($day);
    return $day . ' ' . date("d-m-Y", (strtotime($date)));
}

function parseStringToDay($date)
{
    return date("l", (strtotime($date)));
}


function sortDataResultLottery($ojb)
{
    $array = [];
    foreach ($ojb as $key => $value) {
        $array[$value['prize']][] = $value;
    }
    return $array;
}

function getNameFromPrize($i)
{
    return Cache::remember('getNameFromPrize_' . $i, env('VERY_LONG_CACHE_EXPIRED', 1440), function () use ($i) {
        $array = [
            '0' => 'Đặc Biệt',
            '1' => 'Giải Nhất',
            '2' => 'Giải Nhì',
            '3' => 'Giải Ba',
            '4' => 'Giải Tư',
            '5' => 'Giải Năm',
            '6' => 'Giải Sáu',
            '7' => 'Giải Bảy',
            '8' => 'Giải Tám',
        ];
        return $array[$i];
    });
}


if (!function_exists('getShortNameFromPrize')) {
    function getShortNameFromPrize($i)
    {
        return Cache::remember('getShortNameFromPrize_' . $i, env('VERY_LONG_CACHE_EXPIRED', 1440), function () use ($i) {
            // check status is 1
            $array = [
                '0' => 'G0',
                '1' => 'G1',
                '2' => 'G2',
                '3' => 'G3',
                '4' => 'G4',
                '5' => 'G5',
                '6' => 'G6',
                '7' => 'G7',
                '8' => 'G8',
            ];
            return $array[$i];
        });
    }
}

if (!function_exists('region_left')) {
    function region_left()
    {
        return Cache::remember('region_left', env('LONG_CACHE_EXPIRED', 1440), function () {
            // check status is 1
            $all = \App\Models\Region::with(['provinces'])->isActive()->get()->toArray();
            return $all;
        });
    }
}

if (!function_exists('load_province')) {
    function load_province()
    {
        return Cache::remember('load_province', env('LONG_CACHE_EXPIRED', 1440), function () {
            // check status is 1
            $all = \App\Models\Province::with(['region'])->isActive()->get();
            return $all;
        });
    }
}


//post
if (!function_exists('posts')) {
    function posts()
    {
        return \App\Models\Post::where('active', 1)->orderBy('created_at', 'DESC')->paginate((config("app.nbrPages.front.posts")));
    }
}


function daysOfWeekDisabled($province_id)
{
    if ($province_id) {
        $province = \App\Models\Province::where('id', $province_id)->where('status', 1)->first();
        $array = unserialize($province->weekdays_result_lottery);
        $array = implode(',', $array);
        return $array;
    }
    return [];
}

function array_remove_keys($array, $keys)
{

    // array_diff_key() expected an associative array.
    $assocKeys = array();
    foreach ($keys as $key) {
        $assocKeys[$key] = true;
    }

    return array_diff_key($array, $assocKeys);
}

function parseDataDetailResultLottery($arr)
{
    $array = [];
    foreach ($arr as $key => $ojb) {
        $array[$ojb['province_id']] = sortDataResultLottery($ojb['results_detail']);
    }
    $res = [];
    foreach ($array as $province_id => $data) {
        foreach ($data as $key => $d) {
            foreach ($d as $value) {
                $value['province'] = $province_id;
                $res[$key][$value['order']][] = $value;
            }
        }
    }
    krsort($res, true);
    return $res;
}

// 12 bộ số xuất hiện nhiều nhất trong 40 lần quay gần nhất ( DESC )
// 12 bộ số xuất hiện ít nhất trong 40 lần quay gần nhất ( ASC )

function statistical_two_number_top($province_id, $limit = 100, $order_by = 'DESC')
{
    $all_prize = [];
    $province = \App\Models\Province::where('id', $province_id)->first();
    if ($province->region_id == 2) {
        $listProvince = \App\Models\Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
    } else {
        $listProvince = \App\Models\Province::where('id', $province_id)->pluck('id')->toArray();
    }
    $list_result_lotteries = \App\Models\ResultLottery::with(['resultsDetail'])->whereIn('province_id', $listProvince)->orderBy('result_lotteries.result_day','DESC')->limit($limit)->get();
    foreach ($list_result_lotteries as $key => $resultLottery) {
            foreach ($resultLottery->resultsDetail  as $detail) {
                array_push($all_prize,$detail->prize_number_lotto);
            }
    }
    $data['count'] = array_count_values($all_prize);
    $data['value'] = array_count_values($all_prize);
    if ($order_by == 'DESC') {
        rsort($data['count']);
    } else {
        sort($data['count']);
    }
    $data['count'] = array_slice($data['count'], 0, 12);
    return $data;
}

// Những bộ số không ra từ 10 ngày trở lên (Lô khan)

function get_day_lotto_not_return($province_id, $order = 'DESC')
{
    $province = \App\Models\Province::where('id', $province_id)->first();
    if ($province->region_id == 2) {
        $listProvince = \App\Models\Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
    } else {
        $listProvince = \App\Models\Province::where('id', $province_id)->pluck('id')->toArray();
    }
    $data = Cache::remember('lotto_gan_get_day_lotto_not_return_' . $province_id . md5(date('d-m-Y')), env('VERY_SHORT_CACHE_EXPIRED', 120), function () use ($order, $listProvince) {
        $data = [];
        $start_date = '2018-01-01';
        $end_date = date('Y-m-d', strtotime("+1 days"));
        for ($i = 0; $i <= 99; $i++) {
            $num_check = sprintf('%02d', $i);
            $lottery = \App\Models\LotteryResultDetail::leftJoin('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->whereIn('result_lotteries.province_id', $listProvince)
                ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                ->where('lottery_result_details.prize_number_lotto', $num_check)
                ->orderBy('result_lotteries.result_day', $order)
                ->first();
            if ($lottery) {
                $data[$num_check] = $lottery->result_day;
            }
        }
        return $data;
    });
    $res['count'] = $data;
    $res['value'] = $data;
    sort($res['count']);
    $res['count'] = array_slice($res['count'], 0, 72);
    return $res;
}

function countDateDiff($date)
{
    $cDate = \Carbon\Carbon::parse($date);
    return $cDate->diffInDays();
}

function countBetweenDateDiff($start, $end)
{
    $start = \Carbon\Carbon::parse($start);
    $end = \Carbon\Carbon::parse($end);
    return $end->diffInDays($start);
}

function parseDate($date, $format = 'Y-m-d')
{
    return date($format, (strtotime($date)));
}

// Những bộ số xuất hiện liên tiếp (Lô rơi)

function get_duplicate_lotto($province_id, $order = 'DESC')
{

}

//Thống kê theo đầu số

function get_bingo_head($province_id, $limit = 41, $order = 'DESC')
{
    $province = \App\Models\Province::where('id', $province_id)->first();
    if ($province->region_id == 2) {
        $listProvince = \App\Models\Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
    } else {
        $listProvince = \App\Models\Province::where('id', $province_id)->pluck('id')->toArray();
    }
    $data = Cache::remember('get_bingo_head_' . $province_id . md5(date('d-m-Y')).$limit, env('SHORT_CACHE_EXPIRED', 240), function () use ($listProvince, $limit, $order) {
        $data = [];
        $list_result = \App\Models\ResultLottery::whereIn('result_lotteries.province_id', $listProvince)->orderBy('result_lotteries.result_day', $order)->limit($limit)->pluck('id');
        $lotteries = \App\Models\LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->whereIn('result_lotteries.id', $list_result)
            ->get();
        for ($i = 0; $i <= 9; $i++) {
            $num_check = $i;
            foreach ($lotteries as $key => $lottery) {
                if ($num_check == $lottery->head_lotto) {
                    if (!isset($data[$num_check])) {
                        $data[$num_check] = 0;
                    }
                    $data[$num_check] = $data[$num_check] + 1;
                }
            }
        }
        return $data;
    });
    return $data;
}

//Thống kê theo đuôi số

function get_bingo_end($province_id, $limit = 41, $order = 'DESC')
{
    $province = \App\Models\Province::where('id', $province_id)->first();
    if ($province->region_id == 2) {
        $listProvince = \App\Models\Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
    } else {
        $listProvince = \App\Models\Province::where('id', $province_id)->pluck('id')->toArray();
    }
    $data = Cache::remember('get_bingo_end_' . $province_id . md5(date('d-m-Y')).$limit, env('SHORT_CACHE_EXPIRED', 240), function () use ($listProvince, $limit, $order) {
        $data = [];
        $list_result = \App\Models\ResultLottery::whereIn('result_lotteries.province_id', $listProvince)->orderBy('result_lotteries.result_day', $order)->limit($limit)->pluck('id');
        $lotteries = \App\Models\LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->whereIn('result_lotteries.id', $list_result)
            ->get();
        for ($i = 0; $i <= 9; $i++) {
            $num_check = $i;
            foreach ($lotteries as $key => $lottery) {
                if ($num_check == $lottery->foot_lotto) {
                    if (!isset($data[$num_check])) {
                        $data[$num_check] = 0;
                    }
                    $data[$num_check] = $data[$num_check] + 1;
                }
            }
        }
        return $data;
    });
    return $data;
}

function getFirstLetter($str)
{
    $acronym = '';
    $word = '';
    $words = preg_split("/(\s|\-|\.)/", $str);
    foreach ($words as $w) {
        $acronym .= substr($w, 0, 1);
    }
    $word = $word . $acronym;
    return $word;
}

function get_alias_from_slug($provinceAlias)
{
    $code = Cache::remember('get_alias_from_slug_' . md5($provinceAlias), env('VERY_LONG_CACHE_EXPIRED', 2880), function () use ($provinceAlias) {
        if ($provinceAlias == 'mien-bac') {
            $code = 'mb';
        } else {
            $province = \App\Models\Province::where('slug', trim($provinceAlias))->first()->toArray();
            $code = $province['alias'];
        }
        return $code;
    });
    return $code;
}

function get_name_from_slug($provinceAlias)
{
    $code = Cache::remember('get_name_from_slug_' . md5($provinceAlias), env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias) {
        if ($provinceAlias == 'mien-bac') {
            $code = 'Truyền thống';
        } else {
            $province = \App\Models\Province::where('slug', trim($provinceAlias))->first()->toArray();
            $code = $province['name'];
        }
        return $code;
    });
    return $code;
}


function parseNumber($number)
{
    return sprintf('%02d', intval($number));
}

function percentTotalReturn($number, $total, $limit = 100)
{
    $percent = $number / $total;
    $percent_friendly = number_format($percent * $limit, 2);
    return $percent_friendly;

}

function load_province_result_today()
{
    $today = date('l');
    return Cache::remember('load_province_result_today_' . md5($today), env('LONG_CACHE_EXPIRED', 1440), function () use ($today) {
        $data = [];
        $today = date('l');
        $array = [
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
        ];
        $key = array_search($today, $array);
        $all_province = \App\Models\Province::where('status', 1)->where('region_id', '!=', 2)->get()->toArray();
        foreach ($all_province as $province) {
            if (!in_array($key, unserialize($province['weekdays_result_lottery']))) {
                array_push($data, $province);
            }
        }
        return $data;
    });
}

function timeDiff($to, $end)
{
    $to_time = strtotime($to);
    $from_time = strtotime($end);
    return round(abs($to_time - $from_time) / 60, 2);
}

function maxN(array $numbers, $n)
{
    $maxHeap = new SplMaxHeap;
    foreach ($numbers as $number) {
        $maxHeap->insert($number);
    }
    return iterator_to_array(
        new LimitIterator($maxHeap, 0, $n)
    );
}

function minN(array $numbers, $n)
{
    $minHeap = new SplMinHeap();
    foreach ($numbers as $number) {
        $minHeap->insert($number);
    }
    return iterator_to_array(
        new LimitIterator($minHeap, 0, $n)
    );
}

function array_sort_key($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function get_index_by_day_name($name)
{
    $array = [
        '0' => 'Sunday',
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
    ];
    return array_search($name, $array);
}

function load_notify()
{
    return Cache::remember('load_notify_' . md5(date('d-m-Y')), env('VERY_SHORT_CACHE_EXPIRED', 100), function () {
        return \App\Models\Notify::where('status', 1)->get();
    });
}

function convert_to_vn($name)
{
    $array = [
        'Chủ nhật' => 'Sunday',
        'Thứ hai' => 'Monday',
        'Thứ ba' => 'Tuesday',
        'Thứ tư' => 'Wednesday',
        'Thứ năm' => 'Thursday',
        'Thứ sáu' => 'Friday',
        'Thứ bảy' => 'Saturday',
    ];
    return array_search($name, $array);
}

function load_adv($limit, $position)
{
    return Cache::remember('load_adv_1' . md5(date('d-m-Y')).md5($position).md5($limit),env('VERY_SHORT_ADV_CACHE_EXPIRED',5),function () use ($limit, $position) {
        return \App\Models\Advertise::where('position_to_advertise',$position)->where('status',1)->orderBy('sort_by','ASC')->limit($limit)->get();
    });
}

function str_to_number($str){
    $result  = preg_replace('/[^0-9.]/', '', $str);
    if (!$result) return 0;
    return $result;
}

function echo_now($s){
    echo $s . "<br>";

    flush();
}

function remove_trash_chars($s){
    return preg_replace(['/\r/','/\n/', '/\s/', '/\t/'], '', $s);
}

function format_prize($prize){
    return number_format($prize, 0,'', '.');
}