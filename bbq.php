<?php
##replace the ip address here with the stoker's ip address

$contents = file_get_contents("http://192.168.1.139/stoker.json");

#$out = exec("date -s \"$(curl -s --head http://google.com | grep ^Date: | sed 's/Date: //g') -0600\"");
#$out = str_ireplace("CET","",$out);
#$out = str_ireplace("NOV","",$out);
#$out = str_ireplace(" 2021","",$out);
$out = gmdate('Y-m-d h:i:s', time());

$nowdate = $out;

echo $nowdate;

$contents = '"'.$nowdate.'":'.$contents;

$contents = str_replace("stoker",$nowdate,$contents);

$fp = fopen('data.txt', 'a');//opens file in append mode
fwrite($fp, "\r\n,".$contents);
fclose($fp);


?>





