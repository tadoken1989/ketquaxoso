<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\LotteriesRequest;
use App\Models\LotteryResultDetail;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LotteriesController extends Controller
{
    public function report(Request $request)
    {
        return view('back.lotteries.report');
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->input('search.value');
        $start_date = date('Y-m-d', strtotime("-$length days"));
        $end_date = date('Y-m-d');
        $list = ResultLottery::with(['province', 'resultsDetail'])
            ->whereBetween('result_lotteries.result_day', array(parseDate($start_date), parseDate($end_date)))
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->get();
        $dataTables = DataTables::of($list);
        $dataTables->addColumn('status', function ($list) {
            if ($list->status == 1) {
                return $html = '<span id="status-' . $list->id . '" class="label label-success pull-right"><i class="fa fa-check"></i>' . __("active") . '</span>';
            } else {
                return $html = '<span id="status-' . $list->id . '" class="label label-warning pull-right"><i class="fa fa-check"></i>' . __("hidden") . '</span>';
            }
        });
        $dataTables->addColumn('actions', function ($list) {
            $html = '<a href="' . route('admin.result_lotteries.edit', ['id' => $list->id]) . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> ' . __("Edit") . ' </a>';
            if ($list->status == 1) {
                $html .= '  <a id="status-' . $list->id . '"  href="javascript:;" data-model="result_lotteries" class="btn btn-xs btn-warning btn-active" data-id=' . $list->id . '><i class="fa fa-trash"></i> ' . __("Lock") . '</a>';
            } else {
                $html .= '  <a id="status-' . $list->id . '"  href="javascript:;" data-model="result_lotteries" class="btn btn-xs btn-warning btn-active" data-id=' . $list->id . '><i class="fa fa-check-square-o"></i> ' . __("Active") . '</a>';
            }
            return $html;
        });
        return $dataTables->rawColumns(['status', 'actions'])->make(true);

    }

    public function edit(Request $request)
    {
        $resultLottery = ResultLottery::with(['province', 'resultsDetail'])->where('id', $request->query('id'))->first();
        return view('back.lotteries.edit', compact('resultLottery'));
    }

    public function update(LotteriesRequest $request, $id)
    {
        $detail = LotteryResultDetail::where('result_lottery_id', intval($id))->first();
        if ($detail) {
            $all_prize_number = $request->get('prize_number');
            if ($all_prize_number) {
                foreach ($all_prize_number as $key => $prize_number) {
                    foreach ($prize_number as $order => $num) {
                        $detail = LotteryResultDetail::where('result_lottery_id', intval($id))->where('prize', $key)->where('order', $order)->first();
                        if ($detail) {
                            $detail->prize_number = $num;
                            $detail->prize_number_lotto = substr($num, -2);
                            if ($detail->save()) {
                                $detail->head_lotto = substr($detail->prize_number_lotto, 0, 1);
                                $detail->foot_lotto = substr($detail->prize_number_lotto, 1, 2);
                                $detail->save();
                            }
                        }
                    }
                }
            }
        }
        return back()->with('lotteries-ok', __('The lotteries has been successfully updated'));
    }

    public function create(Request $request)
    {
        $region = $request->get('region_id');
        $provinces = Province::where('region_id', $region)->where('type', 'normal')->pluck('name', 'id');
        if ($region == 2) {
            $type = $request->get('type');
            if (is_null($type)) {
                return view('back.lotteries.create_north', compact('provinces'));

            } elseif ($type == 'thantai') {
                $provinces = Province::where('region_id', $region)->where('type', 'than-tai')->pluck('name', 'id');
                return view('back.lotteries.create_than_tai',compact('provinces'));
            } elseif ($type == '636') {
                $provinces = Province::where('region_id', $region)->where('type', '6-36')->pluck('name', 'id');
                return view('back.lotteries.create_636',compact('provinces'));

            } elseif ($type == '123') {
                $provinces = Province::where('region_id', $region)->where('type', '123')->pluck('name', 'id');
                return view('back.lotteries.create_123',compact('provinces'));
            }
        } elseif ($region == 3 || $region == 1) {
            return view('back.lotteries.create_south', compact('provinces'));
        }
        return false;
    }

    public function store(Request $request)
    {
        $province_id = $request->get('province')[0];
        $provinces = Province::where('id', $province_id)->first();
        if ($provinces->region_id == 2) {
            $this->validate($request, [
                'lotteries_db_content' => 'required',
                'prize_number' => 'required',
                'province' => 'required',
                'result_day' => 'required',
            ]);
        } elseif ($provinces->region_id == 3 || $provinces->region_id == 1) {
            $this->validate($request, [
                'prize_number' => 'required',
                'province' => 'required',
                'result_day' => 'required',
            ]);
        }
        $form = $request->all();
        $request->merge(['status' => $request->has('status')]);
        if ($form) {
            $resultLottery = ResultLottery::where('result_day', $this->parseDate($request->get('result_day')))->where('province_id', $province_id)->first();
            if ($resultLottery) {
                return back()->with('lotteries-error', __('Kết quả ngày này đã tồn tại trong database'));
            } else {
                $resultLottery = new ResultLottery();
                $resultLottery->result_day = $this->parseDate($request->get('result_day'));

                if ($provinces->region_id == 2) {
                    $resultLottery->lotteries_db_content = $request->get('lotteries_db_content');
                    $resultLottery->province_id = getNorthProvinceIdByDate($resultLottery->result_day);
                }else{
                    $resultLottery->province_id = $province_id;
                }

                $resultLottery->status = $request->get('status', false);
                if ($resultLottery->save()) {
                    $all_prize_number = $request->get('prize_number');
                    if ($all_prize_number) {
                        foreach ($all_prize_number as $key => $prize_number) {
                            foreach ($prize_number as $order => $num) {
                                $detail = LotteryResultDetail::where('result_lottery_id', intval($resultLottery->id))->where('prize', $key)->where('order', $order)->first();
                                if (!$detail) {
                                    $detail = new LotteryResultDetail();
                                    $detail->result_lottery_id = $resultLottery->id;
                                    $detail->prize = $key;
                                    $detail->order = $order;
                                    $detail->status = 1;
                                    $detail->prize_number = $num !== null ? $num : '';
                                    $detail->prize_number_lotto = substr($num, -2);
                                    if ($detail->save()) {
                                        $detail->head_lotto = substr($detail->prize_number_lotto, 0, 1);
                                        $detail->foot_lotto = substr($detail->prize_number_lotto, 1, 2);
                                        $detail->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect(route('admin.lotteries.report'))->with('lotteries-ok', __('The lotteries has been successfully created'));
    }
}
