function get_combinations(input,size){var results=[],result,mask,total=Math.pow(2,input.length);for(mask=0;mask<total;mask++){result=[];i=input.length-1;do{if((mask&(1<<i))!==0){result.push(input[i]);}}while(i--);if(result.length>=size){results.push(result);}}
return results;}
function make_lo_xien(numbers_string)
{count_string=$('#count').val();if(isNaN(count_string))
{alert("Vui lòng chọn số thành viên để ghép lô xiên");return false;}
count=parseInt(count_string);inputed_number=[];inputed_number_in_string=[];numbers_string=$('#numbers').val().replace(/[^0-9,]/g,'');string_list=numbers_string.split(',');for(i=0;i<string_list.length;i++)
{abc=string_list[i];def=parseInt(abc)%100;if(inputed_number.indexOf(def)==-1)
{inputed_number.push(def);ghi=('0000'+def);jkl=ghi.substring(ghi.length-2);inputed_number_in_string.push(jkl);}}
if(count>inputed_number.length)
{alert("Bạn không nhập vào đủ bộ số để tạo lô xiên");return false;}
loxien_list=[];all_comb=get_combinations(inputed_number_in_string,count);var target_table=$('#loxien_table');var target_tbody=$('#loxien_table tbody');target_tbody.empty();col_each_row=4;need_new_row=true;new_row=null;counter=0;for(i=0;i<all_comb.length;i++)
{cur_comb=all_comb[i];if(cur_comb.length==count)
{if(need_new_row)
{new_row='<tr>';need_new_row=false;}
counter++;new_row+='<td>'+cur_comb.join(',')+' ;</td>';if(0==counter%col_each_row)
{new_row+='</tr>';$(new_row).appendTo(target_tbody);need_new_row=true;}}}
if(!need_new_row)
{more_cell_count=4-(counter%4);for(i=0;i<more_cell_count;i++)
new_row+='<td></td>';new_row+='</tr>';$(new_row).appendTo(target_tbody);need_new_row=true;}
new_row='<tr class="info"><td class="chu17 vietdam dosam" colspan="'+col_each_row+'"><span class="mauden vietthuong chu15">Tổng số lô xiên tạo được là: </span>'+counter+'</td></tr>';$(new_row).appendTo(target_tbody);if(counter<=0)
{target_table.fadeOut(500);}
else
{target_table.fadeIn(500);$('#loxien_table th').text('Lô xiên '+count);}
return false;}