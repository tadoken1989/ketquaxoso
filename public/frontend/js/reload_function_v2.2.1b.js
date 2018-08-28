cur_len={};finish_status={};reload_interval=2000;notification_sound=true;function reload_result(target_code)
{target_base='.result_div#result_'+target_code;loto_table_td_selector=target_base+' table#loto_'+target_code+' td';reload_url=$(target_base+' #reload_link_'+target_code).text();if(cur_len[target_code]==undefined)
    cur_len[target_code]=0;if(finish_status[target_code]==undefined)
    finish_status[target_code]=false;reload_url+='?t='+Date.now();if(finish_status[target_code])
{return false;}
    mark_province_rolling(target_code)
    $.ajax({url:reload_url,success:function(return_string){result_parts=return_string.split(';');current_time_stamp=Date.now();loaded_time_stemp=parseInt(result_parts[0]+'000');difference=current_time_stamp-loaded_time_stemp;if(difference<0||difference>5*60*1000)
        {return-2;}
            parts=return_string.split(';');bare_digit_string=parts.slice(1,parts.length).join('').replace(/[^0-9*]/g,'');if(cur_len[target_code]<bare_digit_string.length)
            {cur_len[target_code]=bare_digit_string.length;sig_sound('Twinkle');}
            else
            {console.log('not long enough');return-1;}
            var loto_list=[];var loto_special='--';for(i=1;i<result_parts.length;i++)
            {prize_index=result_parts.length-i-1;cur_prize=result_parts[i];if(0==cur_prize.length)
                continue;else
            {var kytutrunggiai=(target_code=='mb'&&prize_index==8);if(kytutrunggiai){prize_parts=[cur_prize];}else{prize_parts=cur_prize.split('-');}
                for(j=0;j<prize_parts.length;j++)
                {cur_prize=prize_parts[j];if(0==cur_prize.length)
                {continue}
                else
                {td_target_string=target_base+' #rs_'+prize_index+'_'+j;console.log(td_target_string);if(!kytutrunggiai){de_lenth=$(td_target_string).attr('rs_len');cur_prize=cur_prize.substring(0,de_lenth);}
                    if(/^\**$/.test(cur_prize)){$(td_target_string).addClass('rolling success');}else if(/^[0-9]*$/.test(cur_prize)||kytutrunggiai){$(td_target_string).removeClass('rolling success');$(td_target_string).text(cur_prize);if(!kytutrunggiai){loto_list.push(cur_prize.substr(-2,2));}
                        if($(td_target_string).hasClass('rs_0')||$(td_target_string).hasClass('stop-reload')){mark_province_complete(target_code);loto_special=cur_prize.substr(-2,2);finish_status[target_code]=true;sig_sound('Carme');}}else{console.log('weird');}}}}}
            loto_list.sort();number_of_loto=$(loto_table_td_selector).length-1;mark_special=false;loto_begin_with=[[],[],[],[],[],[],[],[],[],[]];loto_end_with=[[],[],[],[],[],[],[],[],[],[]];for(i=0;i<number_of_loto;i++)
            {td_index=i+1;blank_strike='\xa0';display_text=(i<loto_list.length)?loto_list[i]:blank_strike;td_obj=$($(loto_table_td_selector).get(td_index));td_obj.removeClass();td_obj.addClass('chu17');td_obj.html(display_text);if(display_text==blank_strike)
                display_text='';loto_span_text=display_text;if(!mark_special&&display_text==loto_special)
            {mark_special=true;td_obj.addClass('giaidb');loto_span_text='<span class="giaidb">'+display_text+'</span>';}
                if(display_text.length)
                {loto_begin_with[parseInt(display_text.substring(0,1))].push(loto_span_text);loto_end_with[parseInt(display_text.substring(1,2))].push(loto_span_text);}}
            for(digit=0;digit<10;digit++)
            {$(target_base+' td#begin_with_'+digit).html(loto_begin_with[digit].join('; '));$(target_base+' td#end_with_'+digit).html(loto_end_with[digit].join('; '));}},timeout:reload_interval});if(!finish_status[target_code])
{setTimeout(function(){reload_result(target_code);},reload_interval);}
    return true;}
function mark_province_complete(p_code)
{target_query='span#roll_marker_'+p_code;$(target_query).text('');$(target_query).removeClass();$(target_query).addClass('pull-right glyphicon glyphicon-ok rolling-finished');return false;}
function mark_province_rolling(p_code)
{target_query='span#roll_marker_'+p_code;$(target_query).text('');$(target_query).removeClass();$(target_query).addClass('pull-right glyphicon glyphicon-repeat fa-spin rolling-progress');return false;}
function notification_switch()
{notification_sound=!notification_sound;$('.notification_switch').each(function(index,element){if(notification_sound)
{$(element).removeClass('fa-volume-off');$(element).addClass('fa-volume-up rolling-finished');}
else
{$(element).removeClass('fa-volume-up rolling-finished');$(element).addClass('fa-volume-off');}});return notification_sound;}
(function($){$.extend({playSound:function(){return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>"+"<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');}});})(jQuery);function sig_sound(sound_file_name)
{if(notification_sound)
{$.playSound('http://static.ketqua.net/noti_sounds/'+sound_file_name);return true;}
    return false;}
function show_modal(province_code)
{modal_body_id='#popup_'+province_code;result_div_id='#result_'+province_code;$(modal_body_id).prepend($(result_div_id).clone());$('#outer_result_'+province_code+' '+result_div_id).attr('id','old_result_'+province_code);modal_id='#kq_modal_'+province_code;$(modal_id).modal('show');return false;}
$(document).ready(function(){$('.kq_modal').each(function(index,element){$(element).on("hidden.bs.modal",function(){province_code=$(this).attr('modaltarget');$('#outer_result_'+province_code).empty();$('#outer_result_'+province_code).prepend($('#result_'+province_code));});$(element).on("shown.bs.modal",function(){province_code=$(this).attr('modaltarget');modal_body_id='#popup_'+province_code;result_div_id='#result_'+province_code;$(modal_body_id).prepend($(result_div_id).clone());$('#outer_result_'+province_code+' '+result_div_id).attr('id','old_result_'+province_code);});});});