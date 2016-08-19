<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?
	include('connect.php');
	$sql = "SELECT * FROM user WHERE user_name = '".$_POST['user']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$_SESSION['User_Name'] = $row['User_Name'];
?>
</head>

<body>
<form id='form' name='form' method='post' action='manageuser.php' >
	<table align="center" width="350" bgcolor="#FFCC55" cellspacing="5">
		<tr>
			<td colspan="2" align="center" height="25"><b>รายละเอียด</b></td>
		</tr>
    	<tr>
        	<td>User Name : </td>
            <td><center><? echo $row['User_Name']?></center></td>
        </tr>
        <tr>
        	<td>Role : </td>
            <td><center><? echo $row['User_Role']?></center></td>
        </tr>
        <tr>
        	<td>Grant Role : </td>
            <td><center><select name="role" size="1" onchange="check()">
            		<option value="0">โปรดเลือก</option>
					<option value="User">พนักงานทั่วไป</option>
					<option value="Creator">ผู้กรอกข้อมูล</option>
	  			</select></center></td>
        </tr>
         <tr>
        	<td colspan="2" align="center">
				<input type="submit" name="submit" value="Submit" disabled="disabled">
            	<input type="submit" name="ban" value="Ban">
                <input type="submit" name="unban" value="Unban">
			</td>
        </tr>
	</table></center>
</form>
</body>
</html>