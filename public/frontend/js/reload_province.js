cur_len = {};
finish_status = {};
function reload_result_prov_page(target_code) {
    console.log('1');
    reload_url = $('#reload_link_' + target_code).text();
    if (cur_len[target_code] == undefined)
        cur_len[target_code] = 0;
    if (finish_status[target_code] == undefined)
        finish_status[target_code] = false;
    reload_url += '?t=' + Date.now();
    if (finish_status[target_code]) {
        return false;
    }
    mark_province_rolling(target_code)
    $.ajax({
        url: reload_url, success: function (return_string) {
            result_parts = return_string.split(';');
            current_time_stamp = Date.now();
            loaded_time_stemp = parseInt(result_parts[0] + '000');
            difference = current_time_stamp - loaded_time_stemp;
            if (difference < 0 || difference > 5 * 60 * 1000) {
                return -2;
            }
            parts = return_string.split(';');
            bare_digit_string = parts.slice(1, parts.length).join('').replace(/[^0-9*]/g, '');
            if (cur_len[target_code] < bare_digit_string.length) {
                cur_len[target_code] = bare_digit_string.length;
                sig_sound('Twinkle');
            }
            else {
                console.log('not long enough');
                return -1;
            }
            loto_list = [];
            loto_special = '--';
            for (i = 1; i < result_parts.length; i++) {
                prize_index = result_parts.length - i - 1;
                cur_prize = result_parts[i];
                if (0 == cur_prize.length)
                    continue; else {
                    prize_parts = cur_prize.split('-');
                    for (j = 0; j < prize_parts.length; j++) {
                        cur_prize = prize_parts[j];
                        if (0 == cur_prize.length) {
                            continue
                        }
                        else {
                            td_target_string = '#' + target_code + '_rs_' + prize_index + '_' + j;
                            de_lenth = $(td_target_string).attr('rs_len');
                            cur_prize = cur_prize.substring(0, de_lenth);
                            if (/^\**$/.test(cur_prize)) {
                                $(td_target_string).addClass('rolling success');
                            }
                            else if (/^[0-9]*$/.test(cur_prize)) {
                                $(td_target_string).removeClass('rolling success');
                                $(td_target_string).text(cur_prize);
                                loto_list.push(cur_prize.substr(-2, 2));
                                if ($(td_target_string).hasClass('rs_0') || $(td_target_string).hasClass('stop-reload')) {
                                    mark_province_complete(target_code);
                                    loto_special = cur_prize.substr(-2, 2);
                                    finish_status[target_code] = true;
                                    sig_sound('Carme');
                                }
                            }
                            else {
                                console.log('weird');
                            }
                        }
                    }
                }
            }
            loto_list.sort();
            number_of_loto = $('#' + target_code + '_loto td').length - 1;
            mark_special = false;
            loto_begin_with = [[], [], [], [], [], [], [], [], [], []];
            loto_end_with = [[], [], [], [], [], [], [], [], [], []];
            for (i = 0; i < number_of_loto; i++) {
                td_index = i + 1;
                blank_strike = '<span class="table_invi hidden-print">-</span>';
                display_text = (i < loto_list.length) ? loto_list[i] : blank_strike;
                td_obj = $($('#' + target_code + '_loto td').get(td_index));
                td_obj.removeClass();
                td_obj.html(display_text);
                if (display_text == blank_strike)
                    display_text = '';
                loto_span_text = display_text;
                if (!mark_special && display_text == loto_special) {
                    mark_special = true;
                    td_obj.addClass('giaidb');
                    loto_span_text = '<span class="giaidb">' + display_text + '</span>';
                }
                if (display_text.length) {
                    loto_begin_with[parseInt(display_text.substring(0, 1))].push(loto_span_text);
                    loto_end_with[parseInt(display_text.substring(1, 2))].push(loto_span_text);
                }
            }
            for (digit = 0; digit < 10; digit++) {
                $('#' + target_code + '_begin_with_' + digit).html(loto_begin_with[digit].join('; '));
                $('#' + target_code + '_end_with_' + digit).html(loto_end_with[digit].join('; '));
            }
        }
    });
    if (!finish_status[target_code]) {
        setTimeout(function () {
            reload_result_prov_page(target_code);
        }, reload_interval);
    }
    return true;
}