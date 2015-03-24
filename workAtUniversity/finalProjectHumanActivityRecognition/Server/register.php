<?php
mysql_connect("localhost","aegistha_thebear","password") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("aegistha_thebear");
mysql_query("SET NAMES UTF8");

if(isset($_POST['Sex']) && isset($_POST['Age']) && isset($_POST['High']) && isset($_POST['Weight']))
{
	$sql = "INSERT INTO Tester VALUES ('','".$_POST['Sex']."','".$_POST['Age']."','".$_POST['High']."','".$_POST['Weight']."')";
	mysql_query($sql) or die(mysql_error());
	$arr['Status'] = '1';
}
else
{
	$arr['Status'] = '0';
}
echo json_encode($arr);
?>
