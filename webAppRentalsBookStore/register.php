<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Register Member</title>
   	<link href="style.css" rel="stylesheet" type="text/css">
	<?
		if(isset($_POST['submit']))
		{
			if($_POST['name'] != "" && $_POST['surname'] != "" && $_POST['address'] != "" && $_POST['email'] != "" && $_POST['tel'] != "")
			{
				session_start();
				include('connect.php');
				$stmt = OCIParse($connection,"SELECT member_id FROM member");
				OCIExecute($stmt);
				$id = oci_fetch_all($stmt,$result);
				$stmt = OCIParse($connection,"INSERT INTO member (MEMBER_ID, FIRSTNAME, LASTNAME, ADDRESS, EMAIL, TEL, DOR) values ('".($id+1)."','".$_POST['name']."','".$_POST['surname']."','".$_POST['address']."','".$_POST['email']."','".$_POST['tel']."',CURRENT_TIMESTAMP)");
				OCIExecute($stmt);
				oci_commit($connection);
				oci_free_statement($stmt);
				ocilogoff($connection);
				$_SESSION['id'] = $id+1;
				header("Location: com_reg.php");
			}else{$error = "กรุณากรอกข้อมูลให้ครบ";}
		}
	?>
	<script type="text/javascript">
		function form_check(check)
		{
			switch (check)
			{
				case "name": if(document.regform.name.value.length == 0){alert('กรุณากรอกค่า')}
							 break;
				case "surname": if(document.regform.surname.value.length == 0){alert('กรุณากรอกค่า')}
								break;
				case "address": if(document.regform.address.value.length == 0){alert('กรุณากรอกค่า')}
								break;
				case "email": if(document.regform.email.value.length == 0){alert('กรุณากรอกค่า')}
								break;
				case "tel": if(document.regform.tel.value.length == 0){alert('กรุณากรอกค่า')}
								break;
				default : break;
			}
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
            <form id="regform" name="regform" method="post" action="register.php">
                <center>
    				<br/><img border="0" src = "images/H-regis.png" /><br/><br/>
                <table>
                    <tr>
                        <td><img border="0" src = "images/T-name.png" /></td>
                        <td><input name="name" type="text" size="32" maxlength="32" onblur="form_check('name')" 
                        style="background-color:#eafbff; border:0; width:250px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                    </tr>
                        
                    <tr>
                        <td><img border="0" src = "images/T-surname.png" /></td>
                        <td><input name="surname" type="text" size="32" maxlength="32" onblur="form_check('surname')" 
                        style="background-color:#eafbff; border:0; width:250px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                    </tr>
                        
                    <tr>
                        <td><img border="0" src = "images/T-address.png" /></td>
                        <td><textarea name="address" rows="3" cols="40" onblur="form_check('address')"
                        style="background-color:#eafbff; border:0; width:300px; height:80px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"></textarea></td>
                    </tr>
                        
                    <tr>
                        <td><img border="0" src = "images/T-email.png" /></td>
                        <td><input name="email" type="text" size="32" maxlength="50" onblur="form_check('email')" 
                        style="background-color:#eafbff; border:0; width:250px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                    </tr>
                        
                    <tr>
                        <td><img border="0" src = "images/T-tel.png" /></td>
                        <td><input name="tel" type="text" size="10" maxlength="10" onblur="form_check('tel')" 
                        style="background-color:#eafbff; border:0; width:180px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                    </tr>
                        
                    <tr>
                        <td></td>
                        <td><input type="button" name="back" value="Back" onclick="javascript:location.href='logon.php'" 
                        	style='background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'/>
                            <input type="submit" name="submit" value="Submit" 
                            style='background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'/>
                      	</td>
                    </tr>
               </table>
                    <? if(isset($error)){echo "<font color='#FF0000'>".$error."</font>";} ?>
               </center>
            </form>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</html>