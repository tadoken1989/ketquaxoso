function trim_array(myArr){for(var i=0;i<myArr.length;i++){myArr[i]=myArr[i].trim();}
return myArr}
function tach_so(numbers_string)
{var result=[];a=$('#numbers').val();b=trim_array(a.split(','));b.forEach(function(element)
{if(element.length<=2)
result.push(element);else if(element.length==3){digits=element.split('');num1=digits[0]+digits[1]
num2=digits[1]+digits[2]
result.push(num1);result.push(num2);}})
var target_div=$('#tachso_div');var target_ul=$('#tachso_ul');target_ul.empty();result.forEach(function(element){ghi=('0000'+element);jkl=ghi.substring(ghi.length-2);li=$('<li/>').addClass('tool-li').text(jkl+',').appendTo(target_ul);})}