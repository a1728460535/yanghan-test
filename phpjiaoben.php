<?php
//php定时计划任务
ignore_user_abort(); // 函数设置与客户机断开是否会终止脚本的执行
set_time_limit(0); // 来设置一个脚本的执行时间为无限长
$interval=30;
$i=1;
do{
	$i++;
$fp = fopen('text3.txt','a');
fwrite($fp,'test');
fclose($fp);
sleep($interval); // 函数延迟代码执行若干秒
}while($i>=0);
?>