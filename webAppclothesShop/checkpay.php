<? session_start();
	//$_SESSION["role"] = "admin";
	//$_SESSION["logined"] = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Check Payment</title>
<?
	if(($_SESSION["role"]=="admin") && $_SESSION["logined"])
	{
		$con = mysql_connect("localhost:3306","root","") or die(mysql_error());
		mysql_select_db("pro",$con);
		if(isset($_POST["update"]))
		{
			$sql = "UPDATE payments SET payment_check = '".$_POST["check"]."' WHERE payment_id = '".$_GET["id"]."'";
			mysql_query($sql,$con);
		}
		$result = mysql_query("SELECT * FROM payments ORDER BY payment_check");
	}
	else
	{
		header("Location: plslogin.php");
	}
?>

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
	<form name="ckeckpay" method="post" action="checkpay.php?id=<? echo $_GET["id"];?>">
			<br/><br/>
		<table border="2" BORDERCOLOR="#ffffff">
			<tr BGCOLOR="7d430a">
				<td><center><img border="0" src = "images/text-SendPayCode2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-BuyName2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-SendPayDate2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-PayCode2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductPrice2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-SendPayBank2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-CheckStatus2.PNG"/></center></td>
                <td><center><img border="0" src = "images/text-Action.PNG"/></center></td>
			</tr>
		<? while($row = mysql_fetch_array($result))
			{?>
        		<tr BGCOLOR="fdd4ac">
					<td><? echo $row["payment_id"];?></td>
					<td><? echo $row["username"];?></td>
					<td><? echo $row["date"];?></td>
					<td><? echo $row["order_id"];?></td>
					<td><? echo $row["cost"];?></td>
					<td><? echo $row["bank"];?></td>
            		<td><? if(isset($_GET["edit"]) && $_GET["id"]==$row["payment_id"]){?><select size="1" name="check"><option value="yes">Yes</option><option value="no">No</option></select><? }else{echo $row["payment_check"];}?></td>
					<td><? if(isset($_GET["edit"]) && $_GET["id"]==$row["payment_id"]){?><input type="submit" name="update" value="Update" /><? }else{?><a href="checkpay.php?edit=true&id=<? echo $row["payment_id"]?>" name="edit" onclick="<? $_POST["edit"]=true;?>">Edit Status</a><? }?></td>
				</tr>
		<? }
			mysql_close($con);?>
       	</table>
        <br/><a href = "home.php"><img border = "0" src = "images/text-ThankBackHome.png"/></a>
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