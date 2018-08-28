<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuRigtController extends Controller
{
    public function listStatistics($slug){
        $detail = Menu::where('slug',$slug)->first();
        $list = Menu::where('parent_id',$detail->id)->get();
        return view('frontend.contentMenuRight.list',compact('list','detail'));
    }
}
