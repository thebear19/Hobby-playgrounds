<?
include("connect.php");
include("button.php");
$prj_id=$_GET['prj_id'];
header('history.back();');
$sql="select * from user_activity u1 join user u2 on (u1.user_id=u2.user_id) where u1.target_entity=".$prj_id." order by DateTime_Of_Activity desc;";
$result=mysql_query($sql) or die(mysql_error());
$num_row = mysql_num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Untitled Document</title>
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td colspan="5"><input type="button" name="info" class="info button gray" id="info" value="ข้อมูลโครงการ" onclick="window.location.replace('projectview.php?prj_id=<?echo $prj_id;?>');"/>
	<input type="button" name="history" class="history button gray" id="history" value="ประวัติการแก้ไข" onclick="window.location.replace('history.php?prj_id=<?echo $prj_id;?>');"/>
	</td>
  </tr>  <tr>
	<td height="5" colspan="5"></td>
  </tr>  
</table>
<table width="800" border="0" cellspacing="0" cellpadding="3" align="center" bgcolor="#e8e8e8"> 
  <tr>
	<td height="10" colspan="5"></td>
  </tr>  
  <tr>
	<td width="50" height="50"></td>
	<td width="180"><b>ประเภทการจัดการ</b></td>
    <td width="140"><b>ส่วนที่จัดการ</b></td>
    <td width="200"><b>วันที่-เวลา</b></td>
	<td><b>โดย</b></td>
  </tr> 
<?
if($num_row!=0){
	while($row=mysql_fetch_array($result)){
?>
 
  <tr>
	<td height="30">>></td>
    <td><? echo $row['Type_Of_System_Activity']; ?></td>
	<td><? echo $row['Type_Of_Target_Entity']; ?></td>
	<td><? echo $row['DateTime_Of_Activity']; ?></td>
	<td><? echo $row['User_Name']; ?></td>
  </tr>
<?
	}
}else{
?>
  <tr>
	<td height="50" colspan="5" align="center"><b><font style="color:red;">ไม่มีประวัติการแก้ไขในโครงการนี้</font></b></td>
  </tr> 
<?
}
?>
</table>
</body>
</html>