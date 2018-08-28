<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Back\Indexable;
use App\Models\DreamNumber;
use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use App\Repositories\LotteriesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DreamNumbersRepository;

class ExtrasController extends Controller
{

    protected $dreamNumbersRepository;
    protected $lotteriesRepository;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\DreamNumbersRepository $repository
     * @param  \App\Repositories\LotteriesRepository $lotteriesRepository
     */
    public function __construct(DreamNumbersRepository $repository, LotteriesRepository $lotteriesRepository)
    {
        parent::__construct();
        $this->dreamNumbersRepository = $repository;
        $this->lotteriesRepository = $lotteriesRepository;
    }

    public function schedule()
    {
        return view('frontend.extras.schedule');
    }

    public function dreamLotto(Request $request)
    {
        $data = [];
        $search_string = '';
        $search_number = '';
        $parameters = $this->getParameters($request);
        if ($request->isMethod('post')) {
            $search_string = $request->get('search_string');
            $search_number = $request->get('search_number');
        }
        if ($search_string != '' && $search_string != '') {
            $data = $this->dreamNumbersRepository->search(config("app.nbrPages.front.dream_numbers"), $search_string, 'all');

        } elseif ($search_number != '') {
            $data = $this->dreamNumbersRepository->search(config("app.nbrPages.front.dream_numbers"), $search_string, 'result_dream');
        } elseif ($search_string != '') {
            $data = $this->dreamNumbersRepository->search(config("app.nbrPages.front.dream_numbers"), $search_string, 'dream_content');
        } else {
            $data = $this->dreamNumbersRepository->getAll(config("app.nbrPages.front.dream_numbers"), $parameters);
        }
        $links = $data->appends($parameters)->links('frontend.partials.pagination');
        return view('frontend.extras.dream_lotto', compact('data', 'search_number', 'search_string', 'links'));
    }

    protected function getParameters($request)
    {
        // Default parameters
        $parameters = config("parameters.dream_numbers");

        // Build parameters with request
        foreach ($parameters as $parameter => &$value) {
            if (isset($request->$parameter)) {
                $value = $request->$parameter;
            }
        }

        return $parameters;
    }

    public function searchResult(Request $request)
    {
        $date = date('Y-m-d', strtotime("-1 days"));
        $number_string = '';
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $date = $this->parseDate($request->get('date'));
            $number_string = intval($request->get('number_string'));
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $data_result = $this->lotteriesRepository->getResultLotteryWithDate($listProvince, $date);
        return view('frontend.extras.search_result', compact('data_result', 'date', 'number_string', 'provinceAlias'));
    }

    public function widget()
    {
        return view('frontend.extras.widget');
    }

    public function football()
    {
        return view('frontend.extras.football');
    }
}
