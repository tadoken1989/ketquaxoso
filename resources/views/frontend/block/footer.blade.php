<div class="row">
    <br>
    <div class="container big-container">
        <table class="table">
            <tbody>
            {!! setting('footer.backlink') !!}
            <tr>
                <td>
                    <div class="pull-left">
                        <h3 class="footerh3 dosam mar0"><strong>Kết quả xổ số</strong></h3>
                        <ul class="footer-col">
                            <li>
                                <h3 class="footerh3 martop10"><a href="{{ url('xo-so-mien-bac')}}">Sổ xố miền Bắc</a>
                                </h3>
                            </li>
                            <li>
                                <h3 class="footerh3"><a href="{{ url('xo-so-mien-trung')}}">Sổ xố miền Trung</a></h3>
                            </li>
                            <li>
                                <h3 class="footerh3"><a href="{{ url('xo-so-mien-name')}}">Sổ xố miền Nam</a></h3>
                            </li>
                            <li><a style="margin-top:8px;font-weight:bold;color:#990000;" href="#">Tiện ích mở rộng</a>
                            </li>
                            <?php $menu = load_menu();?>
                            @foreach($menu[8]['children'] as $item)
                                <li><a href="{{ $item['slug'] }}">{{ $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                <td>
                    <div class="pull-left">
                        <p class="dosam"><strong><a href="#" class="dosam">Thống kê VIP</a></strong></p>
                        <ul class="footer-col">
                            @foreach($menu[5]['children'] as $item)
                                <li><a href="{{ $item['slug'] }}">{{ $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                <td>
                    <div class="pull-left">
                        <p class="dosam"><strong><a href="javascript:;" class="dosam">Soi cầu</a></strong></p>
                        <ul class="footer-col">
                            @foreach($menu[6]['children'] as $item)
                                <li><a href="{{ $item['slug'] }}">{{ $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                <td>
                    <div class="pull-left">
                        <p class="dosam"><strong><a href="javascript:;" class="dosam">Thống kê nhanh</a></strong>
                        </p>
                        <ul class="footer-col">
                            @foreach($menu[7]['children'] as $item)
                                <li><a href="{{ $item['slug'] }}">{{ $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </td>
            </tr>
            {!! setting('footer.content') !!}
            </tbody>
        </table>
        <a href="#" class="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
        <script src="{{ asset('/frontend/js/reload_function_v2.2.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/code.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/metisMenu.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/common.js') }}" type="text/javascript"></script>
    </div>
</div>
@include('frontend.adv.baloon_left')
@include('frontend.adv.baloon_right')
