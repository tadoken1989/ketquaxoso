/*
 * static.ketqua.net
 * public_html/custom_js/
 * reload_function.js - Implement the ability to automatically reload result data for a link
 */

// Object to store the length of result from provinces we will be loading
cur_len = {};
finish_status = {}; // Mark if a province is finished

// Some settings
reload_interval = 2000;
notification_sound = true;

/*
 * TODO
 * Circle Loop for begin rolling
 */
/*
 * Load data from url_to_load and update it to the div with name update_code
 */
function reload_result (target_code)
{
    // Create the link to load from
    target_base = '.result_div#result_' + target_code;
    loto_table_td_selector = target_base + ' table#loto_' + target_code +' td';
    reload_url = $(target_base +' #reload_link_' + target_code).text();

    // SEt cur_len and finish_status
    if (cur_len[target_code] == undefined)
        cur_len[target_code] = 0;
    if (finish_status[target_code] == undefined)
        finish_status[target_code] = false;

    // if (0 == cur_len[target_code])
    reload_url += '?t=' + Date.now();


    // console.log('reload here');
    // TODO
    // Check if it's time window to load
    // Check if this province is not completed yet
    if (finish_status[target_code])
    {
        // console.log('Province ' + target_code + ' is already finished');
        return false;
    }

    // Ok, we load
	// console.log('loading now');
    mark_province_rolling(target_code)
    $.ajax({
        url: reload_url,
        success: function(return_string){
            // Split the return string for many prizes
            result_parts = return_string.split(';');

            // Check the timestamp
            current_time_stamp = Date.now();
            loaded_time_stemp = parseInt(result_parts[0] + '000');
            difference = current_time_stamp - loaded_time_stemp;
            if (difference < 0 || difference > 5 * 60 * 1000)
            {
                // Not a valid timeframe
                // console.log('invalid timestamp in result difference: ' + current_time_stamp + '-' + loaded_time_stemp + '=' + difference);
                return -2;
            }


            // Validate the date and time of result
            parts = return_string.split(';');
            bare_digit_string = parts.slice(1, parts.length).join('').replace(/[^0-9*]/g, '');
            if (cur_len[target_code] < bare_digit_string.length)
            {
                cur_len[target_code] = bare_digit_string.length;
                sig_sound('Twinkle');
            }
            else
            {
                // The result we loaded is not long enough
                console.log('not long enough');
                return -1;
            }

            loto_list = []; // Save the list of all loto for this province so we can sort and display them properly
            loto_special = '--';    // String of the loto for special prize
            for (i = 1; i < result_parts.length; i++) // The first field is the timestamp
            {
                // result_parts - i - 1 will be the index of prize
                prize_index = result_parts.length - i - 1;
                cur_prize = result_parts[i];

                if (0 == cur_prize.length)
                    continue;
                else
                {
                    prize_parts = cur_prize.split('-');
                    for (j = 0; j < prize_parts.length; j++)
                    {
                        // j will be the index of sub-prize
                        cur_prize = prize_parts[j];

                        if (0 == cur_prize.length)
                        {
                            continue
                        }
                        else
                        {
                            // Check if it's a rolling flag
                            td_target_string = target_base + ' #rs_' + prize_index + '_' + j; // We will query for the td to set with this string

                            // Get the desired length
                            de_lenth = $(td_target_string).attr('rs_len');
                            cur_prize = cur_prize.substring(0, de_lenth);
                            // console.log(prize_index + ', ' + j + ', ', + cur_prize);

                            if ( /^\**$/.test(cur_prize))
                            {
                                // it's rolling
                                // console.log('it\'s rolling');
                                $(td_target_string).addClass('rolling success');
                            }
                            else if ( /^[0-9]*$/.test(cur_prize) )
                            {
                                // It's a result string ~> set
                                // console.log('it is a result');
                                // Set the result
                                $(td_target_string).removeClass('rolling success');
                                $(td_target_string).text(cur_prize);

                                loto_list.push(cur_prize.substr(-2, 2));

                                if ($(td_target_string).hasClass('rs_0') || $(td_target_string).hasClass('stop-reload'))
                                {
                                    // This province is finished
                                    mark_province_complete(target_code);
                                    loto_special = cur_prize.substr(-2, 2);

                                    // Stop further reload
                                    finish_status[target_code] = true;

                                    // Sound notification
                                    sig_sound('Carme');
                                }
                            }
                            else
                            {
                                // Undefined
                                console.log('weird');
                            }
                        }
                    }
                }
            }
            // console.log(loto_list);
            loto_list.sort();
            number_of_loto = $(loto_table_td_selector).length - 1;  // Number of loto in the table
            mark_special = false;   // Flag if we already encounter the special prize

            // Array of text for the begin_with and end_with table
            // Mapping from the digit to the list of strings
            loto_begin_with = [[], [], [], [], [], [], [], [], [], []];
            loto_end_with = [[], [], [], [], [], [], [], [], [], []];

            for (i = 0; i < number_of_loto; i++)
            {
                td_index = i + 1;   // Index of the td we will set this logo (offset by 1 because the first in the table is already for the title
                blank_strike = '\xa0';
                display_text = (i < loto_list.length) ? loto_list[i] : blank_strike;
                td_obj = $($(loto_table_td_selector).get(td_index));
                td_obj.removeClass();
                td_obj.addClass('chu17');
                td_obj.html(display_text);

                if (display_text == blank_strike)
                    display_text = '';

                loto_span_text = display_text;  // Text of the loto that will be wrap in a span if it's special prize
                if (!mark_special && display_text == loto_special)
                {
                    // Mark the we have already found the special so we don't
                    // mark other same string
                    mark_special = true;
                    td_obj.addClass('giaidb');
                    loto_span_text = '<span class="giaidb">' + display_text + '</span>';
                }
                if (display_text.length)
                {
                    loto_begin_with[parseInt(display_text.substring(0,1))].push(loto_span_text);
                    loto_end_with[parseInt(display_text.substring(1,2))].push(loto_span_text);
                }
            }

            // Set the text for begin with and end with
            for (digit = 0; digit < 10; digit++)
            {
                $(target_base + ' td#begin_with_' + digit).html(loto_begin_with[digit].join('; '));
                $(target_base + ' td#end_with_' + digit).html(loto_end_with[digit].join('; '));
            }
        },
        timeout: reload_interval
    });

    if (!finish_status[target_code])
    {
        // This province is not finished, set an interval for the reload
        // function
        setTimeout(function(){ reload_result(target_code); }, reload_interval);
    }
    return true;
}

/*
 * Set the class of marker to mark a province as finished rolling
 * With selected p_code
 */
function mark_province_complete(p_code)
{
    target_query = 'span#roll_marker_' + p_code;
    // console.log(target_query);

    $(target_query).text('');

    $(target_query).removeClass();
    $(target_query).addClass('pull-right glyphicon glyphicon-ok rolling-finished');
    return false;
}

/*
 * Set the class of marker to mark a province as rolling
 * with selected p_code
 */
function mark_province_rolling(p_code)
{
    target_query = 'span#roll_marker_' + p_code;
    // console.log(target_query);

    $(target_query).text('');

    $(target_query).removeClass();
    $(target_query).addClass('pull-right glyphicon glyphicon-repeat fa-spin rolling-progress');
    return false;
}

/*
 * Turn on/off the notification sound
 */
function notification_switch()
{
    // Flip the setting
    notification_sound = !notification_sound;

    // Change the notification button
    $('.notification_switch').each(function(index, element){
        // console.log(element);
        if (notification_sound)
        {
            // The sound is on
            $(element).removeClass('fa-volume-off');
            $(element).addClass('fa-volume-up rolling-finished');
        }
        else
        {
            $(element).removeClass('fa-volume-up rolling-finished');
            $(element).addClass('fa-volume-off');
        }
    });
    return notification_sound;
}


/**
 * @author Alexander Manzyuk <admsev@gmail.com>
 * Copyright (c) 2012 Alexander Manzyuk - released under MIT License
 * https://github.com/admsev/jquery-play-sound
 * Usage: $.playSound('http://example.org/sound.mp3');
**/

(function($){

  $.extend({
    playSound: function(){
      return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
    }
  });

})(jQuery);


/*
 * Play the signifying sound from static
 * The name of the file provided by parameter
 */
function sig_sound(sound_file_name)
{
    if (notification_sound)
    {
        $.playSound('http://static.ketqua.net/noti_sounds/' + sound_file_name);
        return true;
    }
    return false;
}

/*
 * Move the result div of a province to its modal and show the modal
 */
function show_modal(province_code)
{
    // move the result div inside of the modal
    modal_body_id = '#popup_' + province_code;
    result_div_id = '#result_' + province_code;

    $(modal_body_id).prepend( $(result_div_id).clone() );

    // Change the name of the old result_div so we don't update the wrong one
    $('#outer_result_' + province_code + ' ' +result_div_id).attr('id', 'old_result_' + province_code);
    modal_id = '#kq_modal_' + province_code;
    $(modal_id).modal('show');

    return false;
}

/*
 * Set event listener for all kq_modal so that when they disappears they will
 * move back the div inside it's outer
 */
$(document).ready(function(){
    $('.kq_modal').each(function(index, element){
        $(element).on("hidden.bs.modal", function(){
            province_code = $(this).attr('modaltarget');
            // CLear the outer div for this
            $('#outer_result_' + province_code).empty();

            $('#outer_result_' + province_code).prepend( $('#result_' + province_code));

        });

        $(element).on("shown.bs.modal", function(){
            province_code = $(this).attr('modaltarget');
            // move the result div inside of the modal
            modal_body_id = '#popup_' + province_code;
            result_div_id = '#result_' + province_code;

            $(modal_body_id).prepend( $(result_div_id).clone() );

            // Change the name of the old result_div so we don't update the wrong one
            $('#outer_result_' + province_code + ' ' +result_div_id).attr('id', 'old_result_' + province_code);
        });
    });

    // Event listener to enable toggle modal
    /*
    $('.kqmodal_toggle').each(function(index, element){
        $(element).on('click touchstart', function() {
            show_modal($(this).attr('modal_target'));
        });
    });
    */
});
