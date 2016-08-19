<?php
mysql_connect("localhost","aegistha_thebear","password") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("aegistha_thebear");
mysql_query("SET NAMES UTF8");

if(isset($_POST['X']))
{
	$sql = "INSERT INTO standsit VALUES ('','".floatval($_POST['X'])."','".floatval($_POST['Y'])."','".floatval($_POST['Z'])."')";
	mysql_query($sql) or die(mysql_error());
}
else if(isset($_POST['OX']))
{
	$sql = "INSERT INTO standsit_o VALUES ('','".floatval($_POST['OX'])."','".floatval($_POST['OY'])."','".floatval($_POST['OZ'])."')";
	mysql_query($sql) or die(mysql_error());
}

?>
