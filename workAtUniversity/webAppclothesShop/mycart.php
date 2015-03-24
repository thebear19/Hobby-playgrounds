<? session_start();
	//session_unset($_SESSION["logined"]);
	//$_SESSION["logined"] = true;
	//$_SESSION["username"] = "test";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My cart</title>
<?
	if(isset($_SESSION["logined"]))
	{
		$con = mysql_connect("localhost:3306","root","") or die(mysql_error());
		mysql_select_db("pro",$con);
		mysql_query("SET NAMES UTF8");
		
		if(isset($_GET["update"]))
		{
			if($_GET["amount"]>0)
			{
				$result = mysql_query("SELECT * FROM store WHERE product_id ='".$_GET["id"]."'");
				$row = mysql_fetch_array($result);
				if($row["product_amount"] > $_GET["amount"])
				{
					$row["product_cost"]*=$_GET["amount"];
					$sql = "UPDATE orders SET cost = '".$row["product_cost"]."',amount = '".$_GET["amount"]."' WHERE product_id='".$_GET["id"]."' AND username ='".$_SESSION["username"]."'";
					mysql_query($sql,$con);
				}
				else{$nomore = true;}
			}
			else{$amount = true;}
		}
			
	 	if(isset($_GET["delete"]))
		{
			$sql = "DELETE FROM orders WHERE product_id='".$_GET["id"]."' AND username ='".$_SESSION["username"]."'";
			mysql_query($sql,$con);
		}
		
		$result = mysql_query("SELECT * FROM orders WHERE username ='".$_SESSION["username"]."' AND order_status = 'wait'");
		if(mysql_num_rows($result)==0){$empty = true;}
	}
	else{header("Location: home.php");}
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
	<form name="mycart" action="mycart.php" method="post">
		<br/>
    	<? if(isset($empty)){echo "ไม่มีสินค้าอยู่ในตะกร้า";}
		   if(isset($amount)){echo "จำนวนสินค้าไม่ถูกต้อง";}
		   if(isset($nomore)){echo "จำนวนสินค้าที่มีอยู่ไม่เพียงพอกับความต้องการของท่าน";} 
		?>
    	<br/>
        <table border="2" BORDERCOLOR="#ffffff">
    		<tr BGCOLOR="7d430a">
           		<td><center><img border="0" src = "images/text-ProductPic2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductName2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductPrice2.PNG"/></center></td>
				<td colspan="2"><center><img border="0" src = "images/text-ProductNum2.PNG"/></center></td>
				<td>ราคารวม</td>
         		<td><center><img border="0" src = "images/text-Action.PNG"/></center></td>
			</tr>
        
		 <? for($value=0;$row = mysql_fetch_array($result);$value+=$row["cost"],$order=$row["order_id"])
			{
				$re = mysql_query("SELECT * FROM store WHERE product_id ='".$row["product_id"]."'");
				$row2 = mysql_fetch_array($re)?>
        		<tr BGCOLOR="fdd4ac">
                    <td><img src="img/resize_<?=$row2["product_img"];?>"></td>
					<td><? echo $row2["product_name"];?></td>
					<td><? echo $row2["product_cost"];?></td>
					<td><? echo $row["amount"];?></td>
                    <td><a href="mycart.php?update=true&id=<? echo $row["product_id"]?>&amount=<? echo $row["amount"]+1;?>" name="update">^</a><br /><a href="mycart.php?update=true&id=<? echo $row["product_id"]?>&amount=<? echo $row["amount"]-1;?>" name="update">v</a></td>
					<td><? echo $row["cost"];?></td>
					<td><a href="mycart.php?delete=true&id=<? echo $row["product_id"]?>" name="delete" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
				</tr>
		 <? }
			mysql_close($con);?>
            <tr BGCOLOR="fec03c">
            	<td colspan="7"><center>ราคารวม : <? echo $value;?> บาท</center></td>
           	</tr>
       	</table>

        <br/>
        <table>
        	<tr>
            	<td width="200"><a href = "home.php"><img border = "0" src = "images/text-ThankBackHome2.png"/></a></td>
                <td width="200"><a href="product.php">ดูสินค้าอื่นๆ</a></td>
                <td><a href="thankout.php?order=true&id=<?=$order?>">ชำระเงิน</a></td>
            </tr>
        </table>
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