var code_to_NOT_days_of_week = {
    'tp-hcm' : [0, 2, 3, 4, 5],
    'dong-thap' : [0, 2, 3, 4, 5, 6],
    'ca-mau' : [0, 2, 3, 4, 5, 6],
    'ben-tre' : [0, 1, 3, 4, 5, 6],
    'vung-tau' : [0, 1, 3, 4, 5, 6],
    'bac-lieu' : [0, 1, 3, 4, 5, 6],
    'dong-nai' : [0, 1, 2, 4, 5, 6],
    'can-tho' : [0, 1, 2, 4, 5, 6],
    'soc-trang' : [0, 1, 2, 4, 5, 6],
    'tay-ninh' : [0, 1, 2, 3, 5, 6],
    'an-giang' : [0, 1, 2, 3, 5, 6],
    'binh-thuan' : [0, 1, 2, 3, 5, 6],
    'vinh-long' : [0, 1, 2, 3, 4, 6],
    'binh-duong' : [0, 1, 2, 3, 4, 6],
    'tra-vinh' : [0, 1, 2, 3, 4, 6],
    'long-an' : [0, 1, 2, 3, 4, 5],
    'hau-giang' : [0, 1, 2, 3, 4, 5],
    'binh-phuoc' : [0, 1, 2, 3, 4, 5],
    'tien-giang' : [1, 2, 3, 4, 5, 6],
    'kien-giang' : [1, 2, 3, 4, 5, 6],
    'da-lat' : [1, 2, 3, 4, 5, 6],
    'thua-t-hue' : [0, 2, 3, 4, 5, 6],
    'phu-yen' : [0, 2, 3, 4, 5, 6],
    'quang-nam' : [0, 1, 3, 4, 5, 6],
    'dak-lak' : [0, 1, 3, 4, 5, 6],
    'da-nang' : [0, 1, 2, 4, 5],
    'khanh-hoa' : [1, 2, 4, 5, 6],
    'binh-dinh' : [0, 1, 2, 3, 5, 6],
    'quang-tri' : [0, 1, 2, 3, 5, 6],
    'quang-binh' : [0, 1, 2, 3, 5, 6],
    'kon-tum' : [1, 2, 3, 4, 5, 6],
    'gia-lai' : [0, 1, 2, 3, 4, 6],
    'ninh-thuan' : [0, 1, 2, 3, 4, 6],
    'quang-ngai' : [0, 1, 2, 3, 4, 5],
    'dak-nong' : [0, 1, 2, 3, 4, 5],
    'ha-noi' : [0,2,3,5,6],
    'quang-ninh' : [0,1,3,4,5,6],
    'bac-ninh' : [0,1,2,4,5,6],
    'hai-phong' : [0,1,2,3,4,6],
    'nam-dinh' : [0,1,2,3,4,5],
    'thai-binh' : [1,2,3,4,5,6],
    'dien-toan-123' : [],
    'dien-toan-6-36' : [0, 1, 2, 4, 5],
    'than-tai' : []
};
var prize_names = ['ĐẶC BIỆT', 'Nhất', 'Nhì', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy', 'Tám',]
$(document).ready(function () {
    $('form#doxoso select#code').change(function () {
        province_code = $('form#doxoso select#code').val();
        $('form#doxoso #date').datepicker('setDaysOfWeekDisabled', code_to_NOT_days_of_week[province_code]);
        $('form#doxoso #date').focus();
    });
    if ($('#doxoso_number_string').length) {
        number_string = $('#doxoso_number_string').text().trim();
        rev_number_string = number_string.split('').reverse().join('').trim();
        win_prizes = [];
        loto_win = [];
        for (giai_index = 0; giai_index < 10; giai_index++) {
            for (sub_giai_index = 0; sub_giai_index < 10; sub_giai_index++) {
                giai_td_id = '#rs_' + giai_index + '_' + sub_giai_index;
                if ($(giai_td_id).length) {
                    prize_number_string = $(giai_td_id).text().trim();
                    rev_prize_number_string = prize_number_string.split('').reverse().join('');
                    check_number_string = rev_number_string.slice(0, rev_prize_number_string.length);
                    if (0 == rev_prize_number_string.indexOf(check_number_string)) {
                        loto_win.push('giải ' + prize_names[giai_index] + '(' + (sub_giai_index + 1) + ')');
                        if (prize_number_string.length <= number_string.length) {
                            $(giai_td_id).addClass("danger");
                            win_prizes.push('giải ' + prize_names[giai_index] + '(' + (sub_giai_index + 1) + ')');
                        }
                        else {
                            $(giai_td_id).addClass("info");
                        }
                    }
                }
            }
        }
        if (win_prizes.length)
            $('#prize_win').text("Chúc mừng bạn đã trúng " + win_prizes.join(' và ')); else $('#prize_win').text("Rất tiếc bạn không trúng số nào");
        $('#loto_win').text('Các giải có số tận cùng trùng với số của bạn: ' + loto_win.join(' và '));
    }
});