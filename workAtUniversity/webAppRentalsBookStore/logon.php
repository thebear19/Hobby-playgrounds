<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>RENG^RIP Book Rental Store</title>
   	<link href="style.css" rel="stylesheet" type="text/css">
    <?
		if(isset($_POST['login']))
		{
			if($_POST['user'] != "" && is_numeric($_POST['user']))
			{
				include('connect.php');
				$stmt = OCIParse($connection,"SELECT member_id FROM member where member_id = ".$_POST['user']);
				OCIExecute($stmt);
				if(oci_fetch_all($stmt,$result)== 1 || $_POST['user']=== "000000") //0 =admin
				{
					session_start();
					$_SESSION['user'] = $_POST['user'];
					header("Location: borrow.php");
				}
				else{echo "<script>alert('ไม่พบผู้ใช้ตามที่ระบุ กรุณากรอกข้อมูลใหม่หรือสมัครสมาชิกใหม่');</script>";}
			}
		}
	?>
    <script>
		function check()
		{
			if((document.form.user.value.length > 0) && (!isNaN(document.form.user.value))){memberCheck();}
			else{alert('กรุณากรอกให้ครบ 1 ตัวอักษรและเป็นตัวเลขเท่านั้น');}
		}
	</script>
</head>

<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="init();">
	<center>
	<div id="container">
		<div id="header">
			<table border="0">
				<tr>
					<td rowspan="2" width="320px"><img border="0" src = "images/LG1.png" /></td>
					<td width="800px" height="80px"></td>
				</tr>
				<tr>
					<td width="800px">
					</td>
				</tr>
			</table> 
		</div>
  		<div id="horizontalnav">
	        <?php require("introduce.php"); ?>
        </div>
		<div id="body">
			<form id='form' name='form' method='post' action='logon.php' >
  				<center>
    				<br/><img border="0" src = "images/H-login.png" /><br/><br/>
                    <table>
                        <tr>
                            <td><img border="0" src = "images/T-id.png" /></td>
                            <td><input name='user' type='text' size='8' maxlength='8' 
                            style="background-color:#eafbff; border:0; width:80px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                            <td><input type='submit' name='login' value='Login' onclick='check()' 
                            style='background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'/></td>
                        </tr>
                        
                        <tr>
                            <td colspan="3"><center><input type='button' name='register' value='Register' onclick="javascript:location.href='register.php'" 
                            style='background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'/>
                            <input type='submit' name='cancel' value='Cancel' 
                            style='background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'/></center>
                            </td>
                        </tr>
                   </table>
                </center>
			</form>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>