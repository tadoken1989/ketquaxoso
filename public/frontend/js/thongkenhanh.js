function parse_numbers_string(numbers_string)
{numbers=numbers_string.split(',');select_num=[];for(i=0;i<numbers.length;i++)
{cur_number=numbers[i].trim();if(cur_number.length==0)
continue;if(isNaN(cur_number))
continue;number_val=parseInt(cur_number)%100;if(number_val<0||number_val>99)
continue;if(select_num.indexOf(number_val))
select_num.push(number_val);}
fade_period=500;if(select_num.length==0)
{$('tr').fadeIn(fade_period);return;}
for(i=0;i<100;i++)
{select_string='tr#'+i;if(select_num.indexOf(i)==-1)
$(select_string).fadeOut(fade_period);else
$(select_string).fadeIn(fade_period);}
return;}
$(document).ready(function(){parse_numbers_string($('#numbers').val());$('#numbers').keyup(function(){parse_numbers_string($('#numbers').val());});});