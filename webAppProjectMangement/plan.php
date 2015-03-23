<?php
session_start();
mysql_connect("localhost","root","") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("gpm");
mysql_query("SET NAMES UTF8");
if(isset($_POST['next'])){
	$sql_id = "select plan_id from annual_objective_plan where plan_name='".$_POST['plan']."'";
	$result_id = mysql_query($sql_id);
	$id = mysql_fetch_array($result_id);
	$_SESSION['plan'] = $_POST['plan'];
	$_SESSION['plan_id'] = $id['plan_id'];
	header("Location:strategy.php");
}
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<!--<script type="text/javascript">
function add(){
	var item = document.getElementById("item");
	item = item.value;
	if(item == "null"){
	$.post("temp.php",{data0:item},function(result){
		$("#show").html(result);	
	});
	}else{
	alert(item);
	$.post("temp.php",{data0:item},function(result){
		$("#show").html(result);	
	});
	}
}
</script>!-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
  <tr align="center">
    <td height="50" width="160" bgcolor="#FFCC00"><a href="projects.php">โครงการทั้งหมด</a></td>
    <td width="160" bgcolor="#FFCC66"><a href="">ค้นหาโครงการ</a></td>
    <td width="160" bgcolor="#FFCC99"><a href=""><b>เพิ่มโครงการ</b></a></td>
    <td width="160">&nbsp;</td>
    <td width="160">&nbsp;</td>
  </tr>
</table>
<form name="plan" method="post">
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
<tr valign="top"><td height="20"></td></tr>
<tr>
	<td height="40"><b>เลือกแผนงานโครงการ</b></td>	
</tr>
<tr><td>
แผนงาน : <select name = "plan" id="item"><option value="null"> โปรดเลือกแผนงาน </option>
			<?php
			$sql = "select plan_name from annual_objective_plan";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
			?>
		 		<option value = "<?php echo $row['plan_name']; ?>" ><?php echo $row['plan_name']; ?></option>
            <?php 
			} 
			?>
        </select>
        
<input type="submit" value="next" name="next" />
        <!--<input type="button" name="add" value = "add" onClick="add()"/>
        <select multiple="multiple" style="width:300px;,height:50px;" name="box">
        <option value="<div id = 'show'></div>">1111</option>
        </select>
        <div id="show"></div>!-->
</td></tr>
</table>
</form>
</body>
</html>