<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage User</title>
<?
	include('connect.php');	
	include('button.php');
	
	if(isset($_POST['submit']))
	{
		$sql = "UPDATE user SET User_Role='".$_POST['role']."' WHERE user_name = '".$_SESSION['User_Name']."'";
		mysql_query($sql);
		$sql = "INSERT INTO user_activity VALUES ('','Grant',CURRENT_TIMESTAMP,'".$_SESSION['User_Name']."','".$_SESSION["No"]."')";
		mysql_query($sql);
		unset($_SESSION['User_Name']);
	}
	else if(isset($_POST['ban']))
	{
		$sql = "UPDATE user SET User_Role='Baner' WHERE user_name = '".$_SESSION['User_Name']."'";
		mysql_query($sql);
		$sql = "INSERT INTO user_activity VALUES ('','Ban',CURRENT_TIMESTAMP,'".$_SESSION['User_Name']."','".$_SESSION["No"]."')";
		mysql_query($sql);
		unset($_SESSION['User_Name']);
	}
	else if(isset($_POST['unban']))
	{
		$sql = "UPDATE user SET User_Role='Wait' WHERE user_name = '".$_SESSION['User_Name']."'";
		mysql_query($sql);
		$sql = "INSERT INTO user_activity VALUES ('','UnBan',CURRENT_TIMESTAMP,'".$_SESSION['User_Name']."','".$_SESSION["No"]."')";
		mysql_query($sql);
		unset($_SESSION['User_Name']);
	}
	/*else if(isset($_POST['delete']))
	{
		$sql = "SELECT * FROM user WHERE user_name = '".$_SESSION['User_Name']."'";
		$row = mysql_fetch_array(mysql_query($sql));
		$sql = "DELETE FROM user_activity WHERE user_id = '".$row['User_ID']."'";
		mysql_query($sql);
		
		$sql = "DELETE FROM user WHERE user_name = '".$_SESSION['User_Name']."'";
		mysql_query($sql);
		unset($_SESSION['User_Name']);
	}*/
	$sql = "SELECT * FROM user WHERE User_Role != 'Admin'";
	$result = mysql_query($sql);
?>
<script type="text/javascript">
	function manage(id)
	{
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("target").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","detail.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("user="+document.getElementById(id).innerHTML);
	}
</script>
<script>
	function check()
	{
		if((document.form.role.value != 0))
		{document.form.submit.disabled=false;}
		else
		{document.form.submit.disabled=true;}
	}
</script>
</head>

<body>
<table width="800" border="0" cellspacing="5" cellpadding="2" align="center" valign="top" bgcolor="#e8e8e8">
	<tr valign="top"><td height="20"><b>รายชื่อผู้ใช้</b> (คลิกที่ชื่อเพื่อแสดงข้อมูล)</td></tr>
	<tr><td>
		<form id='form' name='form' method='post' action='' >
		<center>
			<table width="800" border="0">
				<tr valign="top">
		        	<td width="400"><? echo "<table width=\"350\" cellspacing=\"5\">";
									   $i = 0;
									   while($row = mysql_fetch_array($result)){
											echo "<tr>";
											echo "<td width=\"120\" height=\"20\" id=\"".$i."\" onclick=\"manage(".$i.")\">".$row['User_Name']."</td>";
											if($row['User_Role'] == "Baner"){echo "<td> *BANNED* </td>";}
											echo "</tr>\n";
											$i++;
									   }
									   echo "</table>";
									 ?>
		            </td>
				    <td width="400"><div id="target"> &nbsp; </div></td>
		        </tr>
		    </table>
		</center>
		</form>
	</td></tr>
</table>
</body>
</html>