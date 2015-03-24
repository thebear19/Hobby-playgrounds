<? session_start();
	//$_SESSION["logined"] = true;
	//$_SESSION["username"] = "test";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Profile</title>
<?
	if($_SESSION["logined"])
	{
		$con = mysql_connect("localhost:3306","root","") or die(mysql_error());
		mysql_select_db("pro",$con);
		
		$sql = "SELECT * FROM members WHERE username='".$_SESSION["username"]."'";
		$result = mysql_query($sql,$con);
		$row = mysql_fetch_array($result);
		
		$oldPwd = $newPwd = $cmpNewPwd = $first = $last = $add = $oldEmail = $newEmail = $cmpNewEmail = $tel = $edit = false;
		$cmpp = $cmpm = 0;
		if(isset($_POST["submit"]))
		{
			if(!empty($_POST["oldpass"])){$oldPwd = true;}
			if(!empty($_POST["newpass"])){$newPwd = true;}
			if(!empty($_POST["cmppass"])){$cmpNewPwd = true;}
			if($oldPwd || $newPwd || $cmpNewPwd)
			{
				if($_POST["oldpass"] != $_POST["newpass"])
				{
					if($_POST["newpass"] == $_POST["cmppass"])
					{
						$md5pass = $_POST["oldpass"];
						for($i=0;$i<5;$i++){$md5pass = md5($md5pass);}
						$sql = "SELECT password FROM members WHERE password='$md5pass'";
						$result = mysql_query($sql,$con);
						if(mysql_num_rows($result) == 1)
						{
							if($newPwd && $cmpNewPwd)
							{
								$md5pass = $_POST["newpass"];
								for($i=0;$i<5;$i++){$md5pass = md5($md5pass);}
								$sql = "UPDATE members SET password = '$md5pass' WHERE username = '".$row["username"]."'";
								mysql_query($sql,$con);
							}
						}
						else{$cmpp = 3;}
					}
					else{$cmpp = 2;}
				}
				else{$cmpp = 1;}
			}
			else{$cmpp = 0;}
			
			if(!empty($_POST["oldmail"])){$oldEmail = true;}
			if(!empty($_POST["newmail"])){$newEmail = true;}
			if(!empty($_POST["cmpmail"])){$cmpNewEmail = true;}
			if($oldEmail || $newEmail || $cmpNewEmail)
			{
				if($_POST["oldmail"] != $_POST["newmail"])
				{
					if($_POST["newmail"] == $_POST["cmpmail"])
					{
						$sql = "SELECT email FROM members WHERE email='".$_POST["oldmail"]."'";
						$result = mysql_query($sql,$con);
						if(mysql_num_rows($result) == 1)
						{
							if($newEmail && $cmpNewEmail)
							{
								$sql = "UPDATE members SET email = '".$_POST["newmail"]."' WHERE username = '".$row["username"]."'";
								mysql_query($sql,$con);
							}
						}
						else{$cmpm = 3;}
					}
					else{$cmpm = 2;}
				}
				else{$cmpm = 1;}
			}
			else{$cmpm = 0;}
			
			if(empty($_POST["firstName"])){$first = true;}
			if(empty($_POST["lastName"])){$last = true;}
			if(empty($_POST["address"])){$add = true;}
			if(empty($_POST["tel"])){$tel = true;}
			if(!($first || $last || $add || $tel) && ($cmpp == 0 || $cmpp == 4) && ($cmpm == 0 || $cmpm == 4))
			{
				$sql = "UPDATE members SET firstname = '".$_POST["firstName"]."',lastname = '".$_POST["lastName"]."',address = '".$_POST["address"]."',tel = '".$_POST["tel"]."' WHERE username = '".$row["username"]."'";
				mysql_query($sql,$con);
				$edit = true;
				$sql = "SELECT * FROM members WHERE username='".$_SESSION["username"]."'";
				$result = mysql_query($sql,$con);
				$row = mysql_fetch_array($result);
			}
		}
		elseif(isset($_POST["cancel"]))
		{
			header("Location: home.php");
		}
		mysql_close($con);
	}
	else
	{
		header("Location: home.php");
	}
?>
<script type="text/JavaScript">
	function timedre(timeoutPeriod)
	{
		setTimeout("window.location='editpro.php';",timeoutPeriod);
	}
</script>

<link href="style.css" rel="stylesheet" type="text/css">
</head>

<BODY style="background-image: url(images/BG001.jpg);" bgproperties="fixed" onLoad="init();">
<center>
<div id="container">
<div id="header"></div>
<div id="horizontalnav"></div>
<div id="body">
<br/>
	<center>
	<form method="post" action="editpro.php" name="editpro">
		<br/>
    	<center><? if($edit){echo "แก้ไขข้อมูลเรียบร้อยแล้ว";?><script type="text/JavaScript">timedre(500)</script><? } ?></center>
		<br/>
		<table>
    		<tr>
        		<td><div align=right><img border="0" src = "images/text-Username.PNG"/></div></td>
				<td><? echo $row["username"];?></td>
        	</tr>
        
        	<tr>
        		<td><div align=right>Old Password : </div></td>
        		<td><input type="password" name="oldpass" value="" /></td>
        	</tr>
        
        	<tr>
        		<td><div align=right>New Password : </div></td>
        		<td><input type="password" name="newpass" value="" /></td>
        	</tr>
        
        	<tr>
        		<td><div align=right>Confirm New Password : </div></td>
        		<td><input type="password" name="cmppass" value="" /></td>
        	</tr>
        
        	<tr>
        		<td><div align=right><img border="0" src = "images/text-Firstname.PNG"/></div></td>
       	  		<td><input type="text" name="firstName" value="<? if(!$first && isset($_POST["submit"])){echo $_POST["firstName"];}else{echo $row["firstname"];}?>" /><? if($first){echo "กรุณากรอกชื่อ";}?></td>
        	</tr>
        
        	<tr>
        		<td><div align=right><img border="0" src = "images/text-Lastname.PNG"/></div></td>
        		<td><input type="text" name="lastName" value="<? if(!$last && isset($_POST["submit"])){echo $_POST["lastName"];}else{echo $row["lastname"];}?>" /><? if($last){echo "กรุณากรอกนามสกุล";}?></td>
        	</tr>
        
        	<tr>
        		<td><div align=right><img border="0" src = "images/text-Address.PNG"/></div></td>
        		<td><textarea name="address" rows="3" cols="40"><? if(!$add && isset($_POST["submit"])){echo $_POST["address"];}else{echo $row["address"];}?></textarea><? if($add){echo "กรุณากรอกที่อยู่";}?></td>
        	</tr>
        	
            <tr>
        		<td><div align=right>Old E-mail : </div></td>
        		<td><input type="text" name="oldmail" value="<? if(!$oldEmail && isset($_POST["submit"])){echo $_POST["oldmail"];}else{echo $row["email"];}?>" /></td>
        	</tr>
            
        	<tr>
        		<td><div align=right>New E-mail : </div></td>
        		<td><input type="text" name="newmail" value="" /></td>
        	</tr>
        
        	<tr>
        		<td><div align=right>Confirm New E-mail : </div></td>
        		<td><input type="text" name="cmpmail" value="" /></td>
        	</tr>
        
        	<tr>
        		<td><div align=right><img border="0" src = "images/text-Telephone.PNG"/></div></td>
        		<td><input type="text" name="tel" value="<? if(!$tel && isset($_POST["submit"])){echo $_POST["tel"];}else{echo $row["tel"];}?>" /><? if($tel){echo "กรุณากรอกเบอร์โทรศัพท์";}?></td>
        	</tr>

        	<tr>
        		<td colspan="2"><center><input type="submit" name="submit" value="Submit" style="background-color:#7fc1ff; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px"/>
				<input type="submit" name="cancel" value="Cancel" style="background-color:#ff7fb5; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px"/></center></td>
        	</tr>
    	</table>
        <center><? switch($cmpp)
					{
						case "1":echo "New Password ซ้ำกับของเดิมกรุณาแก้ไขด้วย";break;
						case "2":echo "New Password กับ Confirm New Password ข้อมูลไม่ตรงกันกรุณาแก้ไขด้วย";break;
						case "3":echo "Old Password ไม่ถูกต้องกรุณาแก้ไขด้วย";break;
						default:
					} ?>
                    
         		<? switch($cmpm)
					{
						case "1":echo "New E-mail ซ้ำกับของเดิมกรุณาแก้ไขด้วย";break;
						case "2":echo "New E-mail กับ Confirm New E-mail ข้อมูลไม่ตรงกันกรุณาแก้ไขด้วย";break;
						case "3":echo "Old E-mail ไม่ถูกต้องกรุณาแก้ไขด้วย";break;
						default:
					} ?></center>
	</form>
</center>
</div>

<div id="footer">
<font size="3" face="CordiaUPC" color="#FFFFFF">
<h4><b>copyright &copy; 2012 by BaFaPa Shop</b></h4>

</div>
</center>
</body>
</html>