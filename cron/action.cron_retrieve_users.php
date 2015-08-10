<?php

//require_once ('../../../../config.php');
//$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
//echo $config['db_hostname'];

$link = mysqli_connect('agiwebcoce-ran.mysql.db','agiwebcoce-ran','TypapyzT1','agiwebcoce-ran') or die("Error " . mysqli_error($link));
$query1 = "INSERT INTO demo_adminlog ( timestamp,user_id, username, item_name, action) VALUES(CURRENT_TIMESTAMP,'1', 'Siohan cron', 'Tennis de table', 'Execution tache cron')";
$result = mysqli_query($link,$query1);

#
#EOF
#
?>
