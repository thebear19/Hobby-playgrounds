<?php
session_start();
mysql_connect("localhost","root","") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("gpm");
mysql_query("SET NAMES UTF8");
echo "<meta charset='utf-8'>";
if(isset($_POST['check'])){
	/*$_SESSION['count'] = (int)($_POST['row']);
		for($i=0;$i<(int)($_POST['row']);$i++){
				echo $i.$_POST["aim".$i];
				echo "<br>";
				$_SESSION["aim".$i] = $_POST["aim".$i];
		}
		header("Location:project_insert.php");*/
		echo $_POST['test1'];
		$test = nl2br($_POST['test1']);
		echo "<br>";
		echo $test;
}
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="myform" method="post">

<textarea name="test1" id="test1" cols="90" rows="7" wrap="hard"></textarea>
<input type="submit" value="ok" name = "check" id="check"/>

</form>
</body>
</html>