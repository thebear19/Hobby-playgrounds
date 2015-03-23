<?
include("connect.php");
include('button.php');
if(isset($_GET['del'])){
	/*
	$sql = "delete from aim_project where project_id ='".$_GET['del']."'";
	mysql_query($sql);
	$sql = "delete from fiscal_year_project where project_id ='".$_GET['del']."'";
	mysql_query($sql);
	$sql = "delete from budget_project where project_id='".$_GET['del']."'";
	mysql_query($sql);
	$sql = "delete from project_goal where project_id='".$_GET['del']."'";
	mysql_query($sql);
	
	$rset = mysql_query("select sector_project_id from sector_project where project_id = '".$_GET['del']."'")or die(mysql_error());
	$row = mysql_fetch_array($rset);
	$sp_id = $row['sector_project_id'];
	
	$sql = "delete from activity where Section_Project_ID='".$sp_id."'";
	mysql_query($sql);
	$sql = "delete from sector_project where project_id='".$_GET['del']."'";
	mysql_query($sql);
	
	echo "<meta http-equiv='refresh' content='10'/>";*/
	$sql = "update project set project_status = 'deleted' where project_id = '".$_GET['del']."'";
	echo "<meta http-equiv='refresh' content='10'/>";
	mysql_query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<title>Projects</title>
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#D8D8D8">
<tr><td>
<div id="contentarea">
<table width="800" border="1" cellspacing="0" cellpadding="5" align="center">
<tr bgcolor="#CC9900">
	<td colspan="6" height="30" align="center"><b>หัวข้อโครงการทั้งหมด</b></td>
</tr>
<tr>
	<td align="center" colspan="3" height="30" width="450"><b>ชื่อโครงการ</b></td>
	<td align="center" colspan="2"><b>โดย</b></td>
	<td align="center" colspan="2"><b>ลบ</b></td>
</tr>
<?
$sql="SELECT * FROM project;";
//echo $sql;
mysql_query("SET NAMES UTF8");
$rst=mysql_query($sql);
$num_row = mysql_num_rows($rst);
while($row=mysql_fetch_array($rst)){
	if($row['Project_Status']!="deleted"){
?>
<tr>
	<td colspan="3" height="50" ><li><a href="projectview.php?prj_id=<? echo $row['Project_ID']; ?>"><? echo $row['Project_Name']; ?></a></li></td>
	<td colspan="2" ><? echo $row['Project_Manager']; ?></td>
	<td align="center" colspan="2" >
	<a href="projects.php?del=<? echo $row['Project_ID']; ?>"/><img src="image/trash.png" width="25"/></a>
	</td>
</tr>
<?
	}
}
if($num_row=0){
?>
  <tr>
	<td height="50" colspan="5" align="center"><b><font style="color:red;">ไม่มีโครงการนี้</font></b></td>
  </tr> 
<?
}
?>
</table>
</div>
</td></tr>
</table>
</body>
</html>