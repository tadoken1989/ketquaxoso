function display_qtk(sequence_type)
{fade_period=500;display_rows=generate_number_sequence(sequence_type);if(display_rows.length)
{$('div#common').fadeIn(fade_period);$('div#by_head').fadeOut(fade_period);$('div#by_tail').fadeOut(fade_period);$('div#top15').fadeOut(fade_period);$('div#bottom15').fadeOut(fade_period);for(i=0;i<100;i++)
{select_string='tr#'+i;if(display_rows.indexOf(i)==-1)
$(select_string).fadeOut(fade_period);else
$(select_string).fadeIn(fade_period);}}
else
{$('div#common').fadeOut(fade_period);$('div#by_head').fadeOut(fade_period);$('div#by_tail').fadeOut(fade_period);$('div#top15').fadeOut(fade_period);$('div#bottom15').fadeOut(fade_period);console.log("here");console.log(sequence_type);switch(sequence_type)
{case '9':$('div#by_head').fadeIn(fade_period);break;case '10':$('div#by_tail').fadeIn(fade_period);break;case '11':$('div#top15').fadeIn(fade_period);break;case '12':$('div#bottom15').fadeIn(fade_period);break;}}}