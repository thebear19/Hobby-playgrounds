<?PHP
    mysql_connect("localhost","aegistha_thebear","password") or die(mysql_error());
	mysql_query("SET character_set_results=utf8");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_connection=utf8");
	mysql_select_db("aegistha_thebear");
	mysql_query("SET NAMES UTF8");
	
	$SQL = "SELECT * FROM Activity ORDER BY ID DESC LIMIT 1";
    $result = @mysql_query($SQL) or die("DATABASE ERROR!");
    $total = mysql_num_rows($result);
    if($total != 0)
	{
		$data = mysql_fetch_array($result);
		$max = $data["Max"];
		$min = $data["Min"];
		$type = $data["Index"];
		echo $max.",".$min.",".$type;
	} 
	else{echo "0,0,0";}
    mysql_close();
?>