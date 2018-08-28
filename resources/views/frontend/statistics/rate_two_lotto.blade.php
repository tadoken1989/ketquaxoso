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
        <script src="{{asset('/frontend/js/tansocap_support_v2.6.js')}}" type=""></script>
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
            <table id="number_selector" class="kq-table-hover border table table-condensed kqcenter kqbackground">
                <thead>
                <tr class="info">
                    <th colspan="10">
                        <button class="btn btn-default col-sm-2 col-sm-offset-2" onclick="return set_view(0);">Tất cả
                            các cặp số
                        </button>
                        <button class="btn btn-default col-sm-2 col-sm-offset-1" onclick="return set_view(1);">Không cặp
                            nào
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><label id="lb_00-55"><input type="checkbox" class="number_indi" value="00-55" id="cb_00-55"
                                                    checked=""> 00-55</label></td>
                    <td><label id="lb_01-10"><input type="checkbox" class="number_indi" value="01-10" id="cb_01-10"
                                                    checked=""> 01-10</label></td>
                    <td><label id="lb_02-20"><input type="checkbox" class="number_indi" value="02-20" id="cb_02-20"
                                                    checked=""> 02-20</label></td>
                    <td><label id="lb_03-30"><input type="checkbox" class="number_indi" value="03-30" id="cb_03-30"
                                                    checked=""> 03-30</label></td>
                    <td><label id="lb_04-40"><input type="checkbox" class="number_indi" value="04-40" id="cb_04-40"
                                                    checked=""> 04-40</label></td>
                    <td><label id="lb_05-50"><input type="checkbox" class="number_indi" value="05-50" id="cb_05-50"
                                                    checked=""> 05-50</label></td>
                    <td><label id="lb_06-60"><input type="checkbox" class="number_indi" value="06-60" id="cb_06-60"
                                                    checked=""> 06-60</label></td>
                    <td><label id="lb_07-70"><input type="checkbox" class="number_indi" value="07-70" id="cb_07-70"
                                                    checked=""> 07-70</label></td>
                    <td><label id="lb_08-80"><input type="checkbox" class="number_indi" value="08-80" id="cb_08-80"
                                                    checked=""> 08-80</label></td>
                    <td><label id="lb_09-90"><input type="checkbox" class="number_indi" value="09-90" id="cb_09-90"
                                                    checked=""> 09-90</label></td>
                </tr>
                <tr>
                    <td><label id="lb_11-66"><input type="checkbox" class="number_indi" value="11-66" id="cb_11-66"
                                                    checked=""> 11-66</label></td>
                    <td><label id="lb_12-21"><input type="checkbox" class="number_indi" value="12-21" id="cb_12-21"
                                                    checked=""> 12-21</label></td>
                    <td><label id="lb_13-31"><input type="checkbox" class="number_indi" value="13-31" id="cb_13-31"
                                                    checked=""> 13-31</label></td>
                    <td><label id="lb_14-41"><input type="checkbox" class="number_indi" value="14-41" id="cb_14-41"
                                                    checked=""> 14-41</label></td>
                    <td><label id="lb_15-51"><input type="checkbox" class="number_indi" value="15-51" id="cb_15-51"
                                                    checked=""> 15-51</label></td>
                    <td><label id="lb_16-61"><input type="checkbox" class="number_indi" value="16-61" id="cb_16-61"
                                                    checked=""> 16-61</label></td>
                    <td><label id="lb_17-71"><input type="checkbox" class="number_indi" value="17-71" id="cb_17-71"
                                                    checked=""> 17-71</label></td>
                    <td><label id="lb_18-81"><input type="checkbox" class="number_indi" value="18-81" id="cb_18-81"
                                                    checked=""> 18-81</label></td>
                    <td><label id="lb_19-91"><input type="checkbox" class="number_indi" value="19-91" id="cb_19-91"
                                                    checked=""> 19-91</label></td>
                    <td><label id="lb_22-77"><input type="checkbox" class="number_indi" value="22-77" id="cb_22-77"
                                                    checked=""> 22-77</label></td>
                </tr>
                <tr>
                    <td><label id="lb_23-32"><input type="checkbox" class="number_indi" value="23-32" id="cb_23-32"
                                                    checked=""> 23-32</label></td>
                    <td><label id="lb_24-42"><input type="checkbox" class="number_indi" value="24-42" id="cb_24-42"
                                                    checked=""> 24-42</label></td>
                    <td><label id="lb_25-52"><input type="checkbox" class="number_indi" value="25-52" id="cb_25-52"
                                                    checked=""> 25-52</label></td>
                    <td><label id="lb_26-62"><input type="checkbox" class="number_indi" value="26-62" id="cb_26-62"
                                                    checked=""> 26-62</label></td>
                    <td><label id="lb_27-72"><input type="checkbox" class="number_indi" value="27-72" id="cb_27-72"
                                                    checked=""> 27-72</label></td>
                    <td><label id="lb_28-82"><input type="checkbox" class="number_indi" value="28-82" id="cb_28-82"
                                                    checked=""> 28-82</label></td>
                    <td><label id="lb_29-92"><input type="checkbox" class="number_indi" value="29-92" id="cb_29-92"
                                                    checked=""> 29-92</label></td>
                    <td><label id="lb_33-88"><input type="checkbox" class="number_indi" value="33-88" id="cb_33-88"
                                                    checked=""> 33-88</label></td>
                    <td><label id="lb_34-43"><input type="checkbox" class="number_indi" value="34-43" id="cb_34-43"
                                                    checked=""> 34-43</label></td>
                    <td><label id="lb_35-53"><input type="checkbox" class="number_indi" value="35-53" id="cb_35-53"
                                                    checked=""> 35-53</label></td>
                </tr>
                <tr>
                    <td><label id="lb_36-63"><input type="checkbox" class="number_indi" value="36-63" id="cb_36-63"
                                                    checked=""> 36-63</label></td>
                    <td><label id="lb_37-73"><input type="checkbox" class="number_indi" value="37-73" id="cb_37-73"
                                                    checked=""> 37-73</label></td>
                    <td><label id="lb_38-83"><input type="checkbox" class="number_indi" value="38-83" id="cb_38-83"
                                                    checked=""> 38-83</label></td>
                    <td><label id="lb_39-93"><input type="checkbox" class="number_indi" value="39-93" id="cb_39-93"
                                                    checked=""> 39-93</label></td>
                    <td><label id="lb_44-99"><input type="checkbox" class="number_indi" value="44-99" id="cb_44-99"
                                                    checked=""> 44-99</label></td>
                    <td><label id="lb_45-54"><input type="checkbox" class="number_indi" value="45-54" id="cb_45-54"
                                                    checked=""> 45-54</label></td>
                    <td><label id="lb_46-64"><input type="checkbox" class="number_indi" value="46-64" id="cb_46-64"
                                                    checked=""> 46-64</label></td>
                    <td><label id="lb_47-74"><input type="checkbox" class="number_indi" value="47-74" id="cb_47-74"
                                                    checked=""> 47-74</label></td>
                    <td><label id="lb_48-84"><input type="checkbox" class="number_indi" value="48-84" id="cb_48-84"
                                                    checked=""> 48-84</label></td>
                    <td><label id="lb_49-94"><input type="checkbox" class="number_indi" value="49-94" id="cb_49-94"
                                                    checked=""> 49-94</label></td>
                </tr>
                <tr>
                    <td><label id="lb_56-65"><input type="checkbox" class="number_indi" value="56-65" id="cb_56-65"
                                                    checked=""> 56-65</label></td>
                    <td><label id="lb_57-75"><input type="checkbox" class="number_indi" value="57-75" id="cb_57-75"
                                                    checked=""> 57-75</label></td>
                    <td><label id="lb_58-85"><input type="checkbox" class="number_indi" value="58-85" id="cb_58-85"
                                                    checked=""> 58-85</label></td>
                    <td><label id="lb_59-95"><input type="checkbox" class="number_indi" value="59-95" id="cb_59-95"
                                                    checked=""> 59-95</label></td>
                    <td><label id="lb_67-76"><input type="checkbox" class="number_indi" value="67-76" id="cb_67-76"
                                                    checked=""> 67-76</label></td>
                    <td><label id="lb_68-86"><input type="checkbox" class="number_indi" value="68-86" id="cb_68-86"
                                                    checked=""> 68-86</label></td>
                    <td><label id="lb_69-96"><input type="checkbox" class="number_indi" value="69-96" id="cb_69-96"
                                                    checked=""> 69-96</label></td>
                    <td><label id="lb_78-87"><input type="checkbox" class="number_indi" value="78-87" id="cb_78-87"
                                                    checked=""> 78-87</label></td>
                    <td><label id="lb_79-97"><input type="checkbox" class="number_indi" value="79-97" id="cb_79-97"
                                                    checked=""> 79-97</label></td>
                    <td><label id="lb_89-98"><input type="checkbox" class="number_indi" value="89-98" id="cb_89-98"
                                                    checked=""> 89-98</label></td>
                </tr>
                <tr class="info">
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(30);">Chạm 0</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(31);">Chạm 1</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(32);">Chạm 2</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(33);">Chạm 3</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(34);">Chạm 4</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(35);">Chạm 5</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(36);">Chạm 6</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(37);">Chạm 7</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(38);">Chạm 8</button>
                    </td>
                    <td class="info">
                        <button class="btn btn-default" onclick="return set_view(39);">Chạm 9</button>
                    </td>
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
                <table class="table table-condensed table-bordered table-hover table-responsive kqcenter kqbackground bangts"
                       id="normtable">
                    <thead>
                    <tr class="info border">
                        <th class="kqcenter" style="min-width:50px;max-width:50px;">Ngày - Tháng</th>
                        @foreach($list_date as $d)
                            <th class="kqcenter">{{ parseDate($d['result_day'],'d') }}<br>
                                - {{ parseDate($d['result_day'],'m') }}
                            </th>
                        @endforeach
                        <th class="rotto">
                            <div><span>Tổng lượt về</span></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($data)
                        @foreach($list_lotto as $key => $value)
                            <tr class="tansuatrow" id="tr_{{$key}}-{{$value}}">
                                <td class="info"><b>{{$key}}-{{$value}}<b></b></b></td>
                                <?php $counter = 0;?>
                                @foreach($data as $index_date =>$items)
                                    @if((in_array($key,$items)) && (in_array($value,$items)))
                                        <td class="kqbackground">
                                            <b>2</b>
                                        </td>
                                        <?php $counter = $counter + 2 ?>
                                    @elseif((in_array($key,$items)) || (in_array($value,$items)))
                                        <td class="kqbackground">
                                            <b>1</b>
                                        </td>
                                        <?php $counter = $counter + 1 ?>
                                    @else
                                        <td class="darkgb"><b></b></td>
                                    @endif
                                @endforeach
                                <td class="info"><b>{{ $counter }}</b></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table table-condensed table-bordered table-hover table-responsive kqcenter bangts kqbackground"
                       id="transtable" style="display:none;">
                    <thead>
                    <tr class="info border">
                        <th class="kqcenter" style="max-width:80px;min-width:80px;">Cặp số</th>
                        @foreach($list_lotto as $key => $value)
                            <th class="{{$key}}-{{$value}}">{{ $key }} {{ $value }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index_date =>$items)
                        <tr>
                            <td class="info vietdam">{{ parseDate($index_date,'d-m') }}</td>
                            @foreach($list_lotto as $key => $value)
                                <?php $counter_number = 0; ?>
                                @if((in_array($key,$items)) && (in_array($value,$items)))
                                    <td class="kqbackground {{ $key }}-{{$value}} verti-highlight"
                                        target_class="{{ $key }}-{{$value}}">
                                        <b>
                                            2
                                        </b>
                                    </td>
                                    <?php $counter_number = $counter_number + 2 ?>
                                @elseif((in_array($key,$items)) || (in_array($value,$items)))
                                        <td class="kqbackground {{ $key }}-{{$value}} verti-highlight" target_class="{{ $key }}-{{$value}}">
                                            <b>
                                                1
                                            </b>
                                        </td>
                                        <?php $counter_number = $counter_number + 1 ?>
                                @else
                                    <td class="darkgb {{ $key }}-{{$value}} verti-highlight" target_class="{{ $key }}-{{$value}}">
                                        <b></b>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="info border">
                        <th class="kqcenter">Cặp số</th>
                        @foreach($list_lotto as $key => $value)
                            <th class="{{$key}}-{{$value}}">{{ $key }} {{ $value }}</th>
                        @endforeach
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