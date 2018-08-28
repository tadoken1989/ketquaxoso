function number_pad(num){return('0000'+num).substring(('0000'+num).length-2)}
function trim_array(myArr){for(var i=0;i<myArr.length;i++){myArr[i]=myArr[i].trim();}
return myArr}
function array_pad(arrayx){var arrayz=[];for(var i=0;i<arrayx.length;i++){arrayz.push(number_pad(arrayx[i]))}
return(arrayz)}
function intersect(a,b){var t;if(b.length>a.length)t=b,b=a,a=t;return a.filter(function(e){return b.indexOf(e)>-1;});}
function combine(a,b){var c=a.concat(b);uniquec=c.filter(function(item,pos){return c.indexOf(item)==pos;})
return uniquec}
function subtract(myArray,toRemove){sub12=$.grep(myArray,function(value){return $.inArray(value,toRemove)<0;});return sub12}
function do_all(list,list2){var list1=$('#list1').val();var list2=$('#list2').val();var l1=array_pad(trim_array(list1.split(',')))
var l2=array_pad(trim_array(list2.split(',')))
uniquel1=l1.filter(function(item,pos){return l1.indexOf(item)==pos;})
uniquel2=l2.filter(function(item,pos){return l2.indexOf(item)==pos;})
var dan_trung=intersect(uniquel1,uniquel2)
var dan_ghep=combine(uniquel1,uniquel2)
var loc_dan1=subtract(uniquel1,uniquel2)
var loc_dan2=subtract(uniquel2,uniquel1)
var target_div=$('#dantrung_div');var target_ul=$('#dantrung_ul');target_ul.empty();dan_trung.forEach(function(element){li=$('<li/>').addClass('tool-li').text(element+',').appendTo(target_ul);})
var target_div=$('#danghep_div');var target_ul=$('#danghep_ul');target_ul.empty();dan_ghep.forEach(function(element){li=$('<li/>').addClass('tool-li').text(element+',').appendTo(target_ul);})
var target_div=$('#locdan1_div');var target_ul=$('#locdan1_ul');target_ul.empty();loc_dan1.forEach(function(element){li=$('<li/>').addClass('tool-li').text(element+',').appendTo(target_ul);})
var target_div=$('#locdan2_div');var target_ul=$('#locdan2_ul');target_ul.empty();loc_dan2.forEach(function(element){li=$('<li/>').addClass('tool-li').text(element+',').appendTo(target_ul);})}