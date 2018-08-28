function generate_number_sequence(sequence_type)
{result=[];for(i=0;i<10;i++)
{for(j=0;j<10;j++)
{number_value=i*10+j;if((i+j)%10==sequence_type%10)
result.push(number_value);}}
return result;}