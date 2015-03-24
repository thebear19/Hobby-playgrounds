<?
include('connect.php');
include('button.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Logon</title>
    <?
	if(!isset($_SESSION["login"])){
		if(isset($_POST["login"]))
		{
			$sql = "SELECT * FROM user WHERE User_Name='".$_POST["user"]."' AND User_Password='".$_POST["pass"]."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) == 1)
			{
				$row = mysql_fetch_array($result);
				if($row["User_Role"] == "Baner" || $row["User_Role"] == "Wait")
				{
					$err = "ชื่อผู้ใช้ของท่านมีปัญหากรุณาติดต่อผู้ดูแลระบบ";
				}
				else
				{
					$_SESSION["role"] = $row["User_Role"];
					$_SESSION["username"] = $row["User_Name"];
					$_SESSION["No"] = $row["User_ID"];
					$_SESSION["login"] = true;
					header("Location:projects.php");
				}
			}
			else{$err = "ชื่อผู้ใช้หรือรหัสผิดพลาดกรุณาแก้ไข";}
		}}else{header("Location:projects.php");}
	?>
    <script>
		function check()
		{
			if((document.form.user.value.length > 0) && (document.form.pass.value.length > 0))
			{document.form.login.disabled=false;}
			else
			{document.form.login.disabled=true;}
		}
	</script>
</head>

<body onload="document.form.login.disabled=true;">
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
<tr><td>
<form id='form' name='form' method='post' action='logon.php' >
  	<center>
    	<h1>Log In</h1>
        <table>
        	<tr>
        		<td>ID : </td>
    			<td><input name='user' type='text' onkeyup="check()"/></td>
            </tr>
            
            <tr>
            	<td>Password : </td>
            	<td><input name='pass' type='password' onkeyup="check()"/></td>
            </tr>
            <tr>
            	<td></td>
            	<td><input type='submit' name='login' value='Login'/>
                	<input type='submit' name='cancel' value='Cancel' />
                </td>
            </tr>
       </table>
       <? if(isset($err)){echo "<font color='#FF0000'>".$err."</font>";} ?>
    </center>
</form>
</td></tr>
<tr valign="top"><td height="20"></td></tr>
</body>
</html>