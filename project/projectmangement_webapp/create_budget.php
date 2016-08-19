<?php
session_start();
include('button.php');
mysql_connect("localhost","root","") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("gpm");
mysql_query("SET NAMES UTF8");
$pass = "yes";
if(isset($_POST['submit'])){
	for($i=0;$i<(int)($_POST['row']);$i++){
		if($_POST["source_of_budget".$i] == "" or $_POST["source_des".$i] == ""){
			echo "<script type='text/javascript'> alert('คุณยังกรอกข้อมูลไม่ครบค่ะ'); </script>";	
			echo "<script type='text/javascript'> window.history.go(-1); </script>";
			$pass = "no";
			break;
		}
	}
	if($pass = "yes"){
	for($i=0;$i<(int)($_POST['row']);$i++){
		$sql = "insert into source_of_budget values('','".$_POST["source_of_budget".$i]."','".$_POST["source_des".$i]."')";
		mysql_query($sql)or die(mysql_error());
	}
	echo "<script type=\"text/javascript\"> window.history.go(-2); </script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function add_bud(){
	//window.history.go(-1);
	var row = document.getElementById('row');
	var span = document.getElementById('budget');
	var source_des = document.createElement('input');
	source_des.setAttribute('type',"text");
	source_des.setAttribute('name',"source_des"+row.value);
	source_des.setAttribute('id',"source_des"+row.value);
	source_des.setAttribute('placeholder',"คำอธิบาย");
	
	var source_budget = document.createElement('input');
	source_budget.setAttribute('type',"text");
	source_budget.setAttribute('name',"source_of_budget"+row.value);
	source_budget.setAttribute('id',"source_of_budget"+row.value);
	source_budget.setAttribute('placeholder',"แหล่งงบประมาณ");
	
	var crebutt = document.createElement('br');
		crebutt.setAttribute('name',"br"+row.value);
		crebutt.setAttribute('id',"br"+row.value);
		
	span.appendChild(source_budget);
	span.appendChild(source_des);
	span.appendChild(crebutt);
	row.value++;

}

function del_bud(){
	var span = document.getElementById('budget');
	var row = document.getElementById('row');	
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
	row.value--;
	var source_of_budget = document.getElementById('source_of_budget'+row.value);
	span.removeChild(source_of_budget);
	var type_of_budget = document.getElementById('source_des'+row.value);
	span.removeChild(type_of_budget);
	var br = document.getElementById('br'+row.value);
	span.removeChild(br);
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="insert_budget" method="post">
<table width="800" align="center" bgcolor="#e8e8e8">
<tr>
<td height="35"><b>เพิ่มแหล่งงบประมาณใหม่</b></td>
</tr>
<tr><td>
<input type="text" name="source_of_budget0" id="source_of_budget0" placeholder="แหล่งงบประมาณ" />
<input type="text" name="source_des0" id="source_des0" placeholder="คำอธิบาย"/>

<br />
<span id="budget"></span>
<input type="hidden" name="row" id="row" value="1" />
<input type="button" name="add_b" value="เพิ่มงบประมาณ" onclick="add_bud()" />
<input type="button" name="del_b" value="ลบงบประมาณ" onclick="del_bud()"/>
<input type="submit" name="submit" value = "submit" />
<input type="button" id="back" name="back" value="ย้อนกลับ" onclick="javascript:window.history.go(-1);"/>
</td></tr>
</table>
</form>
</body>
</html>