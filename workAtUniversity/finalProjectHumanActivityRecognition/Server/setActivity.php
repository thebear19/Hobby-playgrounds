<?php
mysql_connect("localhost","aegistha_thebear","password") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("aegistha_thebear");
mysql_query("SET NAMES UTF8");

if(isset($_POST['Max']))
{
	if($_POST['Index'] == 0)
	{
		$sql = "TRUNCATE Activity";
		mysql_query($sql) or die(mysql_error());
	}
	else
	{
		$sql = "INSERT INTO Activity VALUES ('','".floatval($_POST['Max'])."','".floatval($_POST['Min'])."','".intval($_POST['Index'])."')";
		mysql_query($sql) or die(mysql_error());
	}
}

?>
