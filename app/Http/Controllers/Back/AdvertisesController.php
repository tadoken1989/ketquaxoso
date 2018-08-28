<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/27/18
 * Time: 4:44 PM
 */

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\Advertise;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AdvertisesController extends Controller
{
    public function index(Request $request)
    {
        return view('back.advertises.index');
    }

    public function getData(Request $request)
    {
        $list = Advertise::get();
        $dataTables = DataTables::of($list);
        $dataTables->addColumn('status', function ($list) {
            if ($list->status == 1) {
                return $html = '<span id="status-' . $list->id . '" class="label label-success pull-right"><i class="fa fa-check"></i>' . __("active") . '</span>';
            } else {
                return $html = '<span id="status-' . $list->id . '" class="label label-warning pull-right"><i class="fa fa-check"></i>' . __("hidden") . '</span>';
            }
        });
        $dataTables->addColumn('images', function ($list) {
            return '<img src="' . $list->image . '" style="width:120px"/>';
        });
        $dataTables->addColumn('actions', function ($list) {
            $html = '<a href="' . route('admin.advertises.edit', ['id' => $list->id]) . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> ' . __("Edit") . ' </a>';
            if ($list->status == 1) {
                $html .= '  <a id="status-' . $list->id . '"  href="javascript:;" data-model="adv" class="btn btn-xs btn-warning btn-active" data-id=' . $list->id . '><i class="fa fa-trash"></i> ' . __("Lock") . '</a>';
            } else {
                $html .= '  <a id="status-' . $list->id . '"  href="javascript:;" data-model="adv" class="btn btn-xs btn-warning btn-active" data-id=' . $list->id . '><i class="fa fa-check-square-o"></i> ' . __("Active") . '</a>';
            }
            return $html;
        });
        return $dataTables->rawColumns(['status', 'actions', 'images'])->make(true);

    }

    public function edit($id)
    {
        $positions = [
            'baloon_left' => 'baloon_left',
            'baloon_right' => 'baloon_right',
            'header' => 'header',
            'header_top' => 'header_top',
            'right_top' => 'right_top',
            'right_bottom' => 'right_bottom',
            'top_home' => 'top_home'
        ];
        $adv = Advertise::find($id);
        return view('back.advertises.edit', compact('adv', 'positions'));
    }

    public function create()
    {
        $positions = [
            'baloon_left' => 'baloon_left',
            'baloon_right' => 'baloon_right',
            'header' => 'header',
            'header_top' => 'header_top',
            'right_top' => 'right_top',
            'right_bottom' => 'right_bottom',
            'top_home' => 'top_home'
        ];
        return view('back.advertises.create', compact('positions'));
    }


    public function store(Request $request)
    {
        $request->merge(['status' => $request->has('status')]);
        Advertise::create($request->all());
        return back()->with('advertises-ok', __('The advertise has been successfully created'));
    }

    public function update(Request $request, $id)
    {
        $adv = Advertise::find($id);
        $request->merge(['status' => $request->has('status')]);
        $adv->update($request->all());
        return back()->with('advertises-ok', __('The advertise has been successfully updated'));
    }
    /**
     * Remove the post from storage.
     *
     * @param Advertise $adv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertise $adv)
    {
        $adv->delete ();

        return response ()->json ();
    }
}