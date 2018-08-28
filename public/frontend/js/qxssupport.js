function quay_xoso(target_object)
{if(target_object.hasClass('rolling'))
{num_len=target_object.attr('rs_len');rand_number=Math.floor(Math.random()*Math.pow(10,num_len));rand_string=('000000000000000'+rand_number).slice(-1*num_len);target_object.text(rand_string);}
return false;}
var quay_interval=100;function control_rolling()
{$('.rolling').each(function(index,value){quay_xoso($(value));});setTimeout(control_rolling,quay_interval);}
$(document).ready(function(){control_rolling();});