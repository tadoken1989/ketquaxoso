@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table-centered.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center"><h4 class="right-menu-title">Lịch mở thưởng</h4></div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-hover kqbackground table-kq-bold-border table-bordered qtk-hover">
                    <thead>
                    <tr class="info kqcenter">
                        <th class="kqcenter">Ngày</th>
                        <th class="kqcenter"><a class="dosam" href="{{ url('/xo-so-mien-bac') }}">Miền Bắc (18:05)</a></th>
                        <th class="kqcenter"><a class="dosam" href="{{ url('/xo-so-mien-trung') }}">Miền Trung (17:05)</a></th>
                        <th class="kqcenter"><a class="dosam" href="{{ url('/xo-so-mien-nam') }}">Miền Nam (16:05)</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="success">
                        <td class="kqcenter chu15"><b>Thứ hai</b><br><h6><a href="javascript:;">Hôm nay</a></h6></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Phú Yên</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thừa Thiên Huế</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Đồng Tháp</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Hồ Chí Minh</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Cà Mau</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Thứ ba</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="/xổ-số-Đắc-Lắc/">Đắc Lắc</a></li>
                                <li><a class="mauden chu16" href="/xổ-số-Quảng-Nam/">Quảng Nam</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="/xổ-số-Bạc-Liêu/">Bạc Liêu</a></li>
                                <li><a class="mauden chu16" href="/xổ-số-Bến-Tre/">Bến Tre</a></li>
                                <li><a class="mauden chu16" href="/xổ-số-Vũng-Tàu/">Vũng Tàu</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Thứ tư</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 6x36</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Đà Nẵng</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Khánh Hoà</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Cần Thơ</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Đồng Nai</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Sóc Trăng</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Thứ năm</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Bình Định</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Quảng Bình</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Quảng Trị</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="/xổ-số-An-Giang/">An Giang</a></li>
                                <li><a class="mauden chu16" href="/xổ-số-Bình-Thuận/">Bình Thuận</a></li>
                                <li><a class="mauden chu16" href="/xổ-số-Tây-Ninh/">Tây Ninh</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Thứ sáu</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Gia Lai</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Ninh Thuận</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Bình Dương</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Vĩnh Long</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Trà Vinh</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Thứ bảy</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 6x36</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Đắc Nông</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Quảng Ngãi</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Đà Nẵng</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Bình Phước</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Hậu Giang</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Long An</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Hồ Chí Minh</a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="kqcenter chu15"><b>Chủ nhật</b></td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Truyền Thống</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Điện Toán 123</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Thần Tài</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Khánh Hoà</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Kon Tum</a></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li><a class="mauden chu16" href="javascript:;">Đà Lạt</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Kiên Giang</a></li>
                                <li><a class="mauden chu16" href="javascript:;">Tiền Giang</a></li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection