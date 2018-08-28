@if(!isset($province))
    <script type="text/javascript">
        $(document).ready(function () {
            $('#left_date').datepicker({
                format: 'd-m-yyyy', // site date format
                language: 'vi',
                endDate: new Date(),
                weekStart: 1,
                todayBtn: 'linked',
                todayHighlight: true,
                startDate: '-14y',
                daysOfWeekDisabled: ['1', '6']
            }).on('changeDate', function (e) {
                date_obj = e.date;
                new_link = '{!! Request::url() !!}?ngay=' + ("0" + date_obj.getDate()).slice(-2) + '-' + ("0" + (date_obj.getMonth() + 1)).slice(-2) + '-' + date_obj.getFullYear();
                // Navigate
                window.location.href = new_link;
            });
            disable_combine('mb', $('div#left_date'));
            // Set the selected date
            @if(!app('request')->input('ngay'))
            $('#left_date').datepicker('update', '{!! date('d-m-Y') !!}');
            @else
            $('#left_date').datepicker('update', '{!! parseDate(app('request')->input('ngay'),'d-m-Y') !!}');
            @endif
        });

    </script>
@else
    <script type="text/javascript">
        $(document).ready(function () {
            $('#left_date').datepicker({
                format: 'd-m-yyyy', // site date format
                language: 'vi',
                endDate: new Date(),
                weekStart: 1,
                todayBtn: 'linked',
                todayHighlight: true,
                startDate: '-14y',
                daysOfWeekDisabled: [{!! daysOfWeekDisabled($province->id) !!}]
            }).on('changeDate', function (e) {
                date_obj = e.date;
                new_link = '{!! Request::url() !!}?ngay=' + ("0" + date_obj.getDate()).slice(-2) + '-' + ("0" + (date_obj.getMonth() + 1)).slice(-2) + '-' + date_obj.getFullYear();
                // Navigate
                window.location.href = new_link;
            });
            disable_combine('{!! $province->slug !!}', $('div#left_date'));
            // Set the selected date
            @if(!app('request')->input('ngay'))
            $('#left_date').datepicker('update', '{!! date('d-m-Y') !!}');
            @else
            $('#left_date').datepicker('update', '{!! parseDate(app('request')->input('ngay'),'d-m-Y') !!}');
            @endif
        });

    </script>
@endif
