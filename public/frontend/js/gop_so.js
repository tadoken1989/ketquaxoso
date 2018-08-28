function trim_array(myArr){for(var i=0;i<myArr.length;i++){myArr[i]=myArr[i].trim();}
return myArr}
function number_pad(num){return('0000'+num).substring(('0000'+num).length-2)}
function is_palindrome(num1,num2){num1=number_pad(num1)
num2=number_pad(num2)
if(num1.length!=num2.length||num1.length==0){return false;}
var num1_parts=num1.split('').reverse()
var num2_parts=num2.split('')
for(var i=0;i<2;i++){if(num1_parts[i]!=num2_parts[i])
return false}
return true}
function rolling_number(x){var y=(number_pad(x)).split('');var z=y[0]+y[1]+y[0];return z;}
function gop_so(numbers_string){var results=[];var exclusion=[];var a=$('#numbers').val();var b=trim_array(a.split(','));for(var i=0;i<b.length;i++){if($.inArray(b[i],exclusion)!=-1){continue}
var palind=false
for(var j=i+1;j<b.length;j++){if(is_palindrome(b[i],b[j])){var result=rolling_number(b[i]);results.push(result);palind=true
exclusion.push(b[i],b[j])}}
if(palind==false){results.push(number_pad(b[i]))
exclusion.push(b[i])}}
var target_div=$('#gopso_div');var target_ul=$('#gopso_ul');target_ul.empty();results.forEach(function(element){li=$('<li/>').addClass('tool-li').text(element+',').appendTo(target_ul);})}