<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<?
	include('connect.php');
	include('button.php');
	if(isset($_POST['submit']))
	{
		$sql = "SELECT * FROM user WHERE User_Name='".$_POST["username"]."'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 0)
		{
			$sql = "INSERT INTO user VALUES ('','".$_POST["username"]."','".$_POST["password"]."','".$_POST["fname"]."','".$_POST["lname"]."','".$_POST["phone"]."','".$_POST["email"]."','".$_POST["sector"]."','Wait')";
			mysql_query($sql) or die(mysql_error());
			header("Location: logon.php");
		}
		else{$err = "Username ซ้ำกรุณาเปลี่ยนใหม่";}
	}
?>
<script>
	function check()
	{
		if((document.reg.username.value.length > 0) && (document.reg.password.value.length > 5) && (document.reg.phone.value.length > 0) && (document.reg.fname.value.length > 0) && (document.reg.lname.value.length > 0) && (document.reg.sector.value != 0) && (document.reg.email.value.length > 0) && (document.reg.email.value == document.reg.conemail.value) && isNaN(document.reg.fname.value) && isNaN(document.reg.lname.value) && !isNaN(document.reg.phone.value))
		{document.reg.submit.disabled=false;}
		else
		{document.reg.submit.disabled=true;}
	}
</script>
</head>

<body onload="document.reg.submit.disabled=true">
<form name="reg" action="register.php" method="post">
	<center><h1>Register</h1><font color='#FF0000'>กรุณากรอกให้ถูกต้องครบถ้วนทุกช่อง</font><br /><br />
	<table>
    	<tr>
        	<td>Username : </td>
            <td><input type="text" name="username" value="<? if(isset($err)){echo $_POST['username'];} ?>" onkeyup="check()"/></td>
        </tr>
        <tr>
        	<td>Password : </td>
            <td><input type="password" name="password" value="" onkeyup="check()"/> (อย่างน้อย6ตัว)</td>
        </tr>
        <tr>
        	<td>Firstname : </td>
            <td><input type="text" name="fname" value="<? if(isset($err)){echo $_POST['fname'];} ?>" onkeyup="check()"/></td>
        </tr>
        <tr>
        	<td>Lastname : </td>
            <td><input type="text" name="lname" value="<? if(isset($err)){echo $_POST['lname'];} ?>" onkeyup="check()"/></td>
        </tr>
        <tr>
        	<td>หน่วยงานที่สังกัด : </td>
            <td><select name="sector" size="1" onchange="check()">
            	<? 	$sector = mysql_query("SELECT * FROM government_sector");
					for($i=0;$i<mysql_num_rows($sector);$i++)
					{
						$row = mysql_fetch_array($sector);
						if($i == 0){echo "<option value='".$i."'>โปรดเลือก</option>";}
						else{echo "<option value='".$i."'>".$row["Name"]." (".$row["Acronym"].")</option>";}
					}
				?>
	  			</select>
            </td>
        </tr>
        <tr>
        	<td>Phone Number : </td>
            <td><input type="text" name="phone" value="<? if(isset($err)){echo $_POST['phone'];} ?>" maxlength="10" onkeyup="check()"/> (ตย. 08xxxxxxxx)</td>
        </tr>
        <tr>
        	<td>E-mail : </td>
            <td><input type="email" name="email" value="" onkeyup="check()"/></td>
        </tr>
        <tr>
        	<td>Confirm E-mail : </td>
            <td><input type="email" name="conemail" value="" onkeyup="check()"/></td>
        </tr>
        <tr>
        	<td></td>
            <td><input type="submit" name="submit" value="Submit" /> 
            	<input type="submit" name="cancel" value="Cancel" />
                <input type="button" name="back" value="Back" onclick="window.location='logon.php'" />
            </td>
        </tr>
    </table>
    <? if(isset($err)){echo "<font color='#FF0000'>".$err."</font>";} ?>
    </center>
</form>
</body>
</html>