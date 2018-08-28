@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/row_no_gutter.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/table_kq.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/05.1.css')}}" rel="stylesheet">
    <style>
        .big-container {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-10">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tần suất loto</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">- Bạn có thể chọn đánh dấu cho nhiều hàng cùng một lúc. </p>
                        <p class="“text-justify" maudo”="">- Chọn bộ số sau khi đã bấm xem kết quả ở bảng nhập dữ
                            liệu.</p>
                        <p class="“text-justify”">- Màu đỏ là trường hợp về giải đặc biệt.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/js.cookie.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/tanso_support_v2.6.js')}}" type=""></script>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Thống kê tần suất loto</h4>
                </div>
                <div class="panel-body">
                    <form method="POST" id="main_form">
                        {{ csrf_field() }}
                        <div class="form-group col-sm-3 daudong">
                            <label for="code">Tỉnh</label>
                            <select name="code" id="code" class="form-control">
                                @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                                    <option value="mien-bac" selected>Truyền thống</option>
                                @else
                                    <option value="mien-bac">Truyền thống</option>
                                @endif
                                @foreach(load_province() as $pro)
                                    @if($pro->region_id != 2)
                                        @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                            <option value="{{$pro->slug}}" selected>{{$pro->name}}</option>
                                        @else
                                            <option value="{{$pro->slug}}">{{$pro->name}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3 daudong">
                            <label for="date">Biên độ ngày</label>
                            <input type="text" class="form-control" value="{{ parseDate($date,'d-m-Y') }}" id="date"
                                   name="date">
                        </div>
                        <div class="form-group col-sm-3 daudong">
                            <label for="count">Số ngày muốn xem (Max= 1000 ngày)</label>
                            <div class="input-group bootstrap-touchspin">
                                <span class="input-group-addon bootstrap-touchspin-prefix">
                                </span>
                                <input type="text" id="count" class="form-control" name="count" value="{{ $count }}">
                            </div>
                        </div>
                        <div class="form-group col-sm-offset-4 col-sm-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i>Xem kết quả</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <table id="number_selector" class="kq-table-hover table table-condensed kqcenter kqbackground border">
                <thead>
                <tr class="info">
                    <th colspan="11">
                        <button class="btn btn-default col-sm-2 col-sm-offset-1" onclick="return set_view(0);">Tất cả
                            các số
                        </button>
                        <button class="btn btn-default col-sm-2" onclick="return set_view(1);">Không số nào</button>
                        <button class="btn btn-default col-sm-2" onclick="return set_view(2);">Chỉ chọn số chẵn</button>
                        <button class="btn btn-default col-sm-2" onclick="return set_view(3);">Chỉ chọn số lẻ</button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><label id="lb_0"><input type="checkbox" class="number_indi" value="0" id="cb_0" checked="">
                            00</label></td>
                    <td><label id="lb_1"><input type="checkbox" class="number_indi" value="1" id="cb_1" checked="">
                            01</label></td>
                    <td><label id="lb_2"><input type="checkbox" class="number_indi" value="2" id="cb_2" checked="">
                            02</label></td>
                    <td><label id="lb_3"><input type="checkbox" class="number_indi" value="3" id="cb_3" checked="">
                            03</label></td>
                    <td><label id="lb_4"><input type="checkbox" class="number_indi" value="4" id="cb_4" checked="">
                            04</label></td>
                    <td><label id="lb_5"><input type="checkbox" class="number_indi" value="5" id="cb_5" checked="">
                            05</label></td>
                    <td><label id="lb_6"><input type="checkbox" class="number_indi" value="6" id="cb_6" checked="">
                            06</label></td>
                    <td><label id="lb_7"><input type="checkbox" class="number_indi" value="7" id="cb_7" checked="">
                            07</label></td>
                    <td><label id="lb_8"><input type="checkbox" class="number_indi" value="8" id="cb_8" checked="">
                            08</label></td>
                    <td><label id="lb_9"><input type="checkbox" class="number_indi" value="9" id="cb_9" checked="">
                            09</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(10);">Đầu 0</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_10"><input type="checkbox" class="number_indi" value="10" id="cb_10" checked="">
                            10</label></td>
                    <td><label id="lb_11"><input type="checkbox" class="number_indi" value="11" id="cb_11" checked="">
                            11</label></td>
                    <td><label id="lb_12"><input type="checkbox" class="number_indi" value="12" id="cb_12" checked="">
                            12</label></td>
                    <td><label id="lb_13"><input type="checkbox" class="number_indi" value="13" id="cb_13" checked="">
                            13</label></td>
                    <td><label id="lb_14"><input type="checkbox" class="number_indi" value="14" id="cb_14" checked="">
                            14</label></td>
                    <td><label id="lb_15"><input type="checkbox" class="number_indi" value="15" id="cb_15" checked="">
                            15</label></td>
                    <td><label id="lb_16"><input type="checkbox" class="number_indi" value="16" id="cb_16" checked="">
                            16</label></td>
                    <td><label id="lb_17"><input type="checkbox" class="number_indi" value="17" id="cb_17" checked="">
                            17</label></td>
                    <td><label id="lb_18"><input type="checkbox" class="number_indi" value="18" id="cb_18" checked="">
                            18</label></td>
                    <td><label id="lb_19"><input type="checkbox" class="number_indi" value="19" id="cb_19" checked="">
                            19</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(11);">Đầu 1</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_20"><input type="checkbox" class="number_indi" value="20" id="cb_20" checked="">
                            20</label></td>
                    <td><label id="lb_21"><input type="checkbox" class="number_indi" value="21" id="cb_21" checked="">
                            21</label></td>
                    <td><label id="lb_22"><input type="checkbox" class="number_indi" value="22" id="cb_22" checked="">
                            22</label></td>
                    <td><label id="lb_23"><input type="checkbox" class="number_indi" value="23" id="cb_23" checked="">
                            23</label></td>
                    <td><label id="lb_24"><input type="checkbox" class="number_indi" value="24" id="cb_24" checked="">
                            24</label></td>
                    <td><label id="lb_25"><input type="checkbox" class="number_indi" value="25" id="cb_25" checked="">
                            25</label></td>
                    <td><label id="lb_26"><input type="checkbox" class="number_indi" value="26" id="cb_26" checked="">
                            26</label></td>
                    <td><label id="lb_27"><input type="checkbox" class="number_indi" value="27" id="cb_27" checked="">
                            27</label></td>
                    <td><label id="lb_28"><input type="checkbox" class="number_indi" value="28" id="cb_28" checked="">
                            28</label></td>
                    <td><label id="lb_29"><input type="checkbox" class="number_indi" value="29" id="cb_29" checked="">
                            29</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(12);">Đầu 2</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_30"><input type="checkbox" class="number_indi" value="30" id="cb_30" checked="">
                            30</label></td>
                    <td><label id="lb_31"><input type="checkbox" class="number_indi" value="31" id="cb_31" checked="">
                            31</label></td>
                    <td><label id="lb_32"><input type="checkbox" class="number_indi" value="32" id="cb_32" checked="">
                            32</label></td>
                    <td><label id="lb_33"><input type="checkbox" class="number_indi" value="33" id="cb_33" checked="">
                            33</label></td>
                    <td><label id="lb_34"><input type="checkbox" class="number_indi" value="34" id="cb_34" checked="">
                            34</label></td>
                    <td><label id="lb_35"><input type="checkbox" class="number_indi" value="35" id="cb_35" checked="">
                            35</label></td>
                    <td><label id="lb_36"><input type="checkbox" class="number_indi" value="36" id="cb_36" checked="">
                            36</label></td>
                    <td><label id="lb_37"><input type="checkbox" class="number_indi" value="37" id="cb_37" checked="">
                            37</label></td>
                    <td><label id="lb_38"><input type="checkbox" class="number_indi" value="38" id="cb_38" checked="">
                            38</label></td>
                    <td><label id="lb_39"><input type="checkbox" class="number_indi" value="39" id="cb_39" checked="">
                            39</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(13);">Đầu 3</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_40"><input type="checkbox" class="number_indi" value="40" id="cb_40" checked="">
                            40</label></td>
                    <td><label id="lb_41"><input type="checkbox" class="number_indi" value="41" id="cb_41" checked="">
                            41</label></td>
                    <td><label id="lb_42"><input type="checkbox" class="number_indi" value="42" id="cb_42" checked="">
                            42</label></td>
                    <td><label id="lb_43"><input type="checkbox" class="number_indi" value="43" id="cb_43" checked="">
                            43</label></td>
                    <td><label id="lb_44"><input type="checkbox" class="number_indi" value="44" id="cb_44" checked="">
                            44</label></td>
                    <td><label id="lb_45"><input type="checkbox" class="number_indi" value="45" id="cb_45" checked="">
                            45</label></td>
                    <td><label id="lb_46"><input type="checkbox" class="number_indi" value="46" id="cb_46" checked="">
                            46</label></td>
                    <td><label id="lb_47"><input type="checkbox" class="number_indi" value="47" id="cb_47" checked="">
                            47</label></td>
                    <td><label id="lb_48"><input type="checkbox" class="number_indi" value="48" id="cb_48" checked="">
                            48</label></td>
                    <td><label id="lb_49"><input type="checkbox" class="number_indi" value="49" id="cb_49" checked="">
                            49</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(14);">Đầu 4</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_50"><input type="checkbox" class="number_indi" value="50" id="cb_50" checked="">
                            50</label></td>
                    <td><label id="lb_51"><input type="checkbox" class="number_indi" value="51" id="cb_51" checked="">
                            51</label></td>
                    <td><label id="lb_52"><input type="checkbox" class="number_indi" value="52" id="cb_52" checked="">
                            52</label></td>
                    <td><label id="lb_53"><input type="checkbox" class="number_indi" value="53" id="cb_53" checked="">
                            53</label></td>
                    <td><label id="lb_54"><input type="checkbox" class="number_indi" value="54" id="cb_54" checked="">
                            54</label></td>
                    <td><label id="lb_55"><input type="checkbox" class="number_indi" value="55" id="cb_55" checked="">
                            55</label></td>
                    <td><label id="lb_56"><input type="checkbox" class="number_indi" value="56" id="cb_56" checked="">
                            56</label></td>
                    <td><label id="lb_57"><input type="checkbox" class="number_indi" value="57" id="cb_57" checked="">
                            57</label></td>
                    <td><label id="lb_58"><input type="checkbox" class="number_indi" value="58" id="cb_58" checked="">
                            58</label></td>
                    <td><label id="lb_59"><input type="checkbox" class="number_indi" value="59" id="cb_59" checked="">
                            59</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(15);">Đầu 5</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_60"><input type="checkbox" class="number_indi" value="60" id="cb_60" checked="">
                            60</label></td>
                    <td><label id="lb_61"><input type="checkbox" class="number_indi" value="61" id="cb_61" checked="">
                            61</label></td>
                    <td><label id="lb_62"><input type="checkbox" class="number_indi" value="62" id="cb_62" checked="">
                            62</label></td>
                    <td><label id="lb_63"><input type="checkbox" class="number_indi" value="63" id="cb_63" checked="">
                            63</label></td>
                    <td><label id="lb_64"><input type="checkbox" class="number_indi" value="64" id="cb_64" checked="">
                            64</label></td>
                    <td><label id="lb_65"><input type="checkbox" class="number_indi" value="65" id="cb_65" checked="">
                            65</label></td>
                    <td><label id="lb_66"><input type="checkbox" class="number_indi" value="66" id="cb_66" checked="">
                            66</label></td>
                    <td><label id="lb_67"><input type="checkbox" class="number_indi" value="67" id="cb_67" checked="">
                            67</label></td>
                    <td><label id="lb_68"><input type="checkbox" class="number_indi" value="68" id="cb_68" checked="">
                            68</label></td>
                    <td><label id="lb_69"><input type="checkbox" class="number_indi" value="69" id="cb_69" checked="">
                            69</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(16);">Đầu 6</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_70"><input type="checkbox" class="number_indi" value="70" id="cb_70" checked="">
                            70</label></td>
                    <td><label id="lb_71"><input type="checkbox" class="number_indi" value="71" id="cb_71" checked="">
                            71</label></td>
                    <td><label id="lb_72"><input type="checkbox" class="number_indi" value="72" id="cb_72" checked="">
                            72</label></td>
                    <td><label id="lb_73"><input type="checkbox" class="number_indi" value="73" id="cb_73" checked="">
                            73</label></td>
                    <td><label id="lb_74"><input type="checkbox" class="number_indi" value="74" id="cb_74" checked="">
                            74</label></td>
                    <td><label id="lb_75"><input type="checkbox" class="number_indi" value="75" id="cb_75" checked="">
                            75</label></td>
                    <td><label id="lb_76"><input type="checkbox" class="number_indi" value="76" id="cb_76" checked="">
                            76</label></td>
                    <td><label id="lb_77"><input type="checkbox" class="number_indi" value="77" id="cb_77" checked="">
                            77</label></td>
                    <td><label id="lb_78"><input type="checkbox" class="number_indi" value="78" id="cb_78" checked="">
                            78</label></td>
                    <td><label id="lb_79"><input type="checkbox" class="number_indi" value="79" id="cb_79" checked="">
                            79</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(17);">Đầu 7</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_80"><input type="checkbox" class="number_indi" value="80" id="cb_80" checked="">
                            80</label></td>
                    <td><label id="lb_81"><input type="checkbox" class="number_indi" value="81" id="cb_81" checked="">
                            81</label></td>
                    <td><label id="lb_82"><input type="checkbox" class="number_indi" value="82" id="cb_82" checked="">
                            82</label></td>
                    <td><label id="lb_83"><input type="checkbox" class="number_indi" value="83" id="cb_83" checked="">
                            83</label></td>
                    <td><label id="lb_84"><input type="checkbox" class="number_indi" value="84" id="cb_84" checked="">
                            84</label></td>
                    <td><label id="lb_85"><input type="checkbox" class="number_indi" value="85" id="cb_85" checked="">
                            85</label></td>
                    <td><label id="lb_86"><input type="checkbox" class="number_indi" value="86" id="cb_86" checked="">
                            86</label></td>
                    <td><label id="lb_87"><input type="checkbox" class="number_indi" value="87" id="cb_87" checked="">
                            87</label></td>
                    <td><label id="lb_88"><input type="checkbox" class="number_indi" value="88" id="cb_88" checked="">
                            88</label></td>
                    <td><label id="lb_89"><input type="checkbox" class="number_indi" value="89" id="cb_89" checked="">
                            89</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(18);">Đầu 8</button>
                    </td>
                </tr>
                <tr>
                    <td><label id="lb_90"><input type="checkbox" class="number_indi" value="90" id="cb_90" checked="">
                            90</label></td>
                    <td><label id="lb_91"><input type="checkbox" class="number_indi" value="91" id="cb_91" checked="">
                            91</label></td>
                    <td><label id="lb_92"><input type="checkbox" class="number_indi" value="92" id="cb_92" checked="">
                            92</label></td>
                    <td><label id="lb_93"><input type="checkbox" class="number_indi" value="93" id="cb_93" checked="">
                            93</label></td>
                    <td><label id="lb_94"><input type="checkbox" class="number_indi" value="94" id="cb_94" checked="">
                            94</label></td>
                    <td><label id="lb_95"><input type="checkbox" class="number_indi" value="95" id="cb_95" checked="">
                            95</label></td>
                    <td><label id="lb_96"><input type="checkbox" class="number_indi" value="96" id="cb_96" checked="">
                            96</label></td>
                    <td><label id="lb_97"><input type="checkbox" class="number_indi" value="97" id="cb_97" checked="">
                            97</label></td>
                    <td><label id="lb_98"><input type="checkbox" class="number_indi" value="98" id="cb_98" checked="">
                            98</label></td>
                    <td><label id="lb_99"><input type="checkbox" class="number_indi" value="99" id="cb_99" checked="">
                            99</label></td>
                    <td class="info">
                        <button class="btn btn-xs btn-default" onclick="return set_view(19);">Đầu 9</button>
                    </td>
                </tr>
                <tr class="info">
                    <td>
                        <button class="btn btn-default" onclick="return set_view(20);">Đuôi 0</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(21);">Đuôi 1</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(22);">Đuôi 2</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(23);">Đuôi 3</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(24);">Đuôi 4</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(25);">Đuôi 5</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(26);">Đuôi 6</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(27);">Đuôi 7</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(28);">Đuôi 8</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="return set_view(29);">Đuôi 9</button>
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <h3><p class="kqcenter kqbackground nendosam mautrang chu16 viethoa" style="padding:2px;">Thống kê tần suất
                    loto Truyền Thống trong vòng {{ $count }} ngày trước {{ parseDate($date) }}</p></h3>
            <div class="kqbackground"><p class="chu15 daudong vietnghieng"
                                         style="margin-top:-10px;margin-bottom:-10px;padding:10px;"><span class="maudo"> Hướng dẫn</span>:
                    B1 - Chọn tỉnh và khoảng ngày muốn xem. =&gt; B2 - Chọn nhanh bộ số muốn xem (<span class="maudo">KHÔNG</span>
                    cần bấm Enter). Màu đỏ là trường hợp về giải đặc biệt. Bấm TRỢ GIÚP để xem thêm hướng dẫn.</p></div>
            <button class="btn btn-xs btn-success" id="change_view">Xem theo chiều ngang</button>
            <br><br>
            <div class="scroll">
                <table class="table table-condensed table-bordered table-hover table-responsive kqcenter bangts kqbackground"
                       id="normtable">
                    <thead>
                    <tr class="info border">
                        <th class="kqcenter" style="max-width:50px;min-width:50px;">Ngày - Tháng</th>
                        @foreach($list_date as $d)
                            <th class="kqcenter">{{ parseDate($d['result_day'],'d') }}<br>
                                - {{ parseDate($d['result_day'],'m') }}</th>
                        @endforeach
                        <th>
                            <div><span>Tổng lượt về</span></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($data)
                        @for ($i = 0; $i <= 99; $i++)
                            <tr class="tansuatrow" id="tr_{{ $i }}">
                                <td class="info"><b>{{  sprintf('%02d', $i) }}</b></td>
                                <?php
                                $number = sprintf('%02d', $i);
                                $counter = 0;
                                ?>
                                @foreach($data as $index_date =>$items)
                                    @if(in_array($number,$items))
                                        <td class="kqbackground">
                                            <b>
                                                <?php $count = array_count_values($items) ?>
                                                {{ $count[$number] }}
                                            </b>
                                        </td>
                                        <?php $counter = $counter + $count[$number] ?>
                                    @else
                                        <td class="darkgb"><b></b></td>
                                    @endif
                                @endforeach
                                <td class="info"><b>{{ $counter }}</b></td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table table-condensed table-bordered table-hover table-responsive kqcenter bangts kqbackground"
                       id="transtable" style="display:none;">
                    <thead>
                    <tr class="info border">
                        <th class="kqcenter" style="max-width:80px;min-width:80px;">Ngày</th>
                        <th class="0">00</th>
                        <th class="1">01</th>
                        <th class="2">02</th>
                        <th class="3">03</th>
                        <th class="4">04</th>
                        <th class="5">05</th>
                        <th class="6">06</th>
                        <th class="7">07</th>
                        <th class="8">08</th>
                        <th class="9">09</th>
                        <th class="10">10</th>
                        <th class="11">11</th>
                        <th class="12">12</th>
                        <th class="13">13</th>
                        <th class="14">14</th>
                        <th class="15">15</th>
                        <th class="16">16</th>
                        <th class="17">17</th>
                        <th class="18">18</th>
                        <th class="19">19</th>
                        <th class="20">20</th>
                        <th class="21">21</th>
                        <th class="22">22</th>
                        <th class="23">23</th>
                        <th class="24">24</th>
                        <th class="25">25</th>
                        <th class="26">26</th>
                        <th class="27">27</th>
                        <th class="28">28</th>
                        <th class="29">29</th>
                        <th class="30">30</th>
                        <th class="31">31</th>
                        <th class="32">32</th>
                        <th class="33">33</th>
                        <th class="34">34</th>
                        <th class="35">35</th>
                        <th class="36">36</th>
                        <th class="37">37</th>
                        <th class="38">38</th>
                        <th class="39">39</th>
                        <th class="40">40</th>
                        <th class="41">41</th>
                        <th class="42">42</th>
                        <th class="43">43</th>
                        <th class="44">44</th>
                        <th class="45">45</th>
                        <th class="46">46</th>
                        <th class="47">47</th>
                        <th class="48">48</th>
                        <th class="49">49</th>
                        <th class="50">50</th>
                        <th class="51">51</th>
                        <th class="52">52</th>
                        <th class="53">53</th>
                        <th class="54">54</th>
                        <th class="55">55</th>
                        <th class="56">56</th>
                        <th class="57">57</th>
                        <th class="58">58</th>
                        <th class="59">59</th>
                        <th class="60">60</th>
                        <th class="61">61</th>
                        <th class="62">62</th>
                        <th class="63">63</th>
                        <th class="64">64</th>
                        <th class="65">65</th>
                        <th class="66">66</th>
                        <th class="67">67</th>
                        <th class="68">68</th>
                        <th class="69">69</th>
                        <th class="70">70</th>
                        <th class="71">71</th>
                        <th class="72">72</th>
                        <th class="73">73</th>
                        <th class="74">74</th>
                        <th class="75">75</th>
                        <th class="76">76</th>
                        <th class="77">77</th>
                        <th class="78">78</th>
                        <th class="79">79</th>
                        <th class="80">80</th>
                        <th class="81">81</th>
                        <th class="82">82</th>
                        <th class="83">83</th>
                        <th class="84">84</th>
                        <th class="85">85</th>
                        <th class="86">86</th>
                        <th class="87">87</th>
                        <th class="88">88</th>
                        <th class="89">89</th>
                        <th class="90">90</th>
                        <th class="91">91</th>
                        <th class="92">92</th>
                        <th class="93">93</th>
                        <th class="94">94</th>
                        <th class="95">95</th>
                        <th class="96">96</th>
                        <th class="97">97</th>
                        <th class="98">98</th>
                        <th class="99">99</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index_date =>$items)
                        <tr>
                            <td class="info vietdam">{{ parseDate($index_date,'d-m') }}</td>
                            @for ($i = 0; $i <= 99; $i++)
                                <?php
                                $number = sprintf('%02d', $i);
                                $counter_number = 0;
                                ?>
                                @if(!in_array($number,$items))
                                    <td class="darkgb {{$i}} verti-highlight" target_class="{{ $i }}">
                                        <b></b>
                                    </td>
                                @else
                                    <td class="kqbackground {{ $i }} verti-highlight" target_class="{{ $i }}">
                                        <b>
                                            <?php $count = array_count_values($items) ?>
                                            {{ $count[$number] }}
                                        </b>
                                    </td>
                                    <?php $counter_number = $counter_number + $count[$number] ?>
                                @endif
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="info border">
                        <td class="vietdam">Bộ số</td>
                        <th class="0">00</th>
                        <th class="1">01</th>
                        <th class="2">02</th>
                        <th class="3">03</th>
                        <th class="4">04</th>
                        <th class="5">05</th>
                        <th class="6">06</th>
                        <th class="7">07</th>
                        <th class="8">08</th>
                        <th class="9">09</th>
                        <th class="10">10</th>
                        <th class="11">11</th>
                        <th class="12">12</th>
                        <th class="13">13</th>
                        <th class="14">14</th>
                        <th class="15">15</th>
                        <th class="16">16</th>
                        <th class="17">17</th>
                        <th class="18">18</th>
                        <th class="19">19</th>
                        <th class="20">20</th>
                        <th class="21">21</th>
                        <th class="22">22</th>
                        <th class="23">23</th>
                        <th class="24">24</th>
                        <th class="25">25</th>
                        <th class="26">26</th>
                        <th class="27">27</th>
                        <th class="28">28</th>
                        <th class="29">29</th>
                        <th class="30">30</th>
                        <th class="31">31</th>
                        <th class="32">32</th>
                        <th class="33">33</th>
                        <th class="34">34</th>
                        <th class="35">35</th>
                        <th class="36">36</th>
                        <th class="37">37</th>
                        <th class="38">38</th>
                        <th class="39">39</th>
                        <th class="40">40</th>
                        <th class="41">41</th>
                        <th class="42">42</th>
                        <th class="43">43</th>
                        <th class="44">44</th>
                        <th class="45">45</th>
                        <th class="46">46</th>
                        <th class="47">47</th>
                        <th class="48">48</th>
                        <th class="49">49</th>
                        <th class="50">50</th>
                        <th class="51">51</th>
                        <th class="52">52</th>
                        <th class="53">53</th>
                        <th class="54">54</th>
                        <th class="55">55</th>
                        <th class="56">56</th>
                        <th class="57">57</th>
                        <th class="58">58</th>
                        <th class="59">59</th>
                        <th class="60">60</th>
                        <th class="61">61</th>
                        <th class="62">62</th>
                        <th class="63">63</th>
                        <th class="64">64</th>
                        <th class="65">65</th>
                        <th class="66">66</th>
                        <th class="67">67</th>
                        <th class="68">68</th>
                        <th class="69">69</th>
                        <th class="70">70</th>
                        <th class="71">71</th>
                        <th class="72">72</th>
                        <th class="73">73</th>
                        <th class="74">74</th>
                        <th class="75">75</th>
                        <th class="76">76</th>
                        <th class="77">77</th>
                        <th class="78">78</th>
                        <th class="79">79</th>
                        <th class="80">80</th>
                        <th class="81">81</th>
                        <th class="82">82</th>
                        <th class="83">83</th>
                        <th class="84">84</th>
                        <th class="85">85</th>
                        <th class="86">86</th>
                        <th class="87">87</th>
                        <th class="88">88</th>
                        <th class="89">89</th>
                        <th class="90">90</th>
                        <th class="91">91</th>
                        <th class="92">92</th>
                        <th class="93">93</th>
                        <th class="94">94</th>
                        <th class="95">95</th>
                        <th class="96">96</th>
                        <th class="97">97</th>
                        <th class="98">98</th>
                        <th class="99">99</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('extra-js')
    <script type="">
        var view_state = true;
        $(document).ready(function () {
            $('#date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form #date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#date'));

            // Set the curerent last day
            $('#date').datepicker('update', '{!! parseDate($date,'d-m-Y') !!}');

            $('#count').TouchSpin({
                min: 1,
                max: 1000,
                step: 1,
                postfix: ' ngày'
            });

            // Switch between views
            $('#change_view').click(function () {
                $('#change_view').toggleClass('btn-warning');
                $('#change_view').toggleClass('btn-success');
                view_state = !view_state;

                if (view_state) {
                    $('#change_view').text('Xem theo chiều ngang');
                    $('#normtable').show();
                    $('#transtable').hide();
                }
                else {
                    $('#change_view').text('Xem theo chiều dọc');
                    $('#normtable').hide();
                    $('#transtable').show();
                }

                // Set the view based on our cookie
                if (Cookies.get(tslt_se_cookie) != undefined) {
                    showing_selected = all_numbers;
                    set_selected(JSON.parse(Cookies.get(tslt_se_cookie)));
                    console.log('Restored view from cookie');
                }
                else {
                    set_view(0);
                    console.log('Set all view');
                }
            });
        });
    </script>
@endsection