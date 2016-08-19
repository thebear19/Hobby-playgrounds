<? session_start();
	//$_SESSION["role"] = "admin";
	//$_SESSION["logined"] = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Store</title>
<?
	if(($_SESSION["role"]=="admin") && $_SESSION["logined"])
	{
		$pname = $amou = $cost = $detail = $rep = false;
		$upname = $uamou = $ucost = $urep = false;
		
		$con = mysql_connect("localhost:3306","root","") or die(mysql_error());
		mysql_select_db("pro",$con);
		mysql_query("SET NAMES UTF8");
		
		if(isset($_POST["submit"]))
		{
			if(empty($_POST["pname"])){$pname = true;}
			if(empty($_POST["amou"])){$amou = true;}
			if(empty($_POST["cost"])){$cost = true;}
			
			if(trim($_FILES["fileUpload"]["tmp_name"]) != "" && !($pname || $amou || $cost))
			{
				$images = $_FILES["fileUpload"]["tmp_name"];
				$new_images = "resize_".$_FILES["fileUpload"]["name"];
				copy($_FILES["fileUpload"]["tmp_name"],"img/".$_FILES["fileUpload"]["name"]);
				$width = 100;
				$size = GetimageSize($images);
				$height = round($width*$size[1]/$size[0]);
				$images_orig = ImageCreateFromJPEG($images);
				$photoX = ImagesX($images_orig);
				$photoY = ImagesY($images_orig);
				$images_fin = ImageCreateTrueColor($width, $height);
				ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
				ImageJPEG($images_fin,"img/".$new_images);
				ImageDestroy($images_orig);
				ImageDestroy($images_fin);
			
				$sql = "SELECT * FROM store WHERE product_name = '".$_POST["pname"]."'";
				$result = mysql_query($sql,$con);
				if(mysql_num_rows($result) == 1){$rep = true;}
				
				if(!$rep)
				{
					$id = mysql_query("SELECT MAX(no) FROM store");
					$id = mysql_fetch_array($id);
					$id = $id["MAX(no)"];
					$id++;
					$no = $id;
					if($_POST["type"] == "clothing"){$id = "@CL00".$id;}else{$id = "@SH00".$id;}
					$sql = "INSERT INTO store VALUES('$no','$id','".$_FILES["fileUpload"]["name"]."','".$_POST["pname"]."','".$_POST["amou"]."','".$_POST["cost"]."','".$_POST["type"]."','".$_POST["detail"]."')";
					mysql_query($sql,$con);
				}
			}
		}
		
		if(isset($_GET["update"])){$_SESSION["id"] = $_GET["id"];}
		if(isset($_POST["update"]))
		{
			if(empty($_POST["upname"])){$upname = true;}
			if(empty($_POST["uamou"])){$uamou = true;}
			if(empty($_POST["ucost"])){$ucost = true;}
			
			if(!($upname || $uamou || $ucost))
			{
				$sql = "SELECT * FROM store WHERE product_name = '".$_POST["upname"]."'";
				$result = mysql_query($sql,$con);
				if(mysql_num_rows($result) == 1){$urep = true;}
				
				if(!$urep)
				{
					$sql = "UPDATE store SET product_name = '".$_POST["upname"]."',product_amount = '".$_POST["uamou"]."',product_cost = '".$_POST["ucost"]."',product_detail = '".$_POST["udetail"]."' WHERE product_id='".$_SESSION["id"]."'";
					mysql_query($sql,$con);
					unset($_SESSION["id"]);
				}
			}
		}
		elseif(isset($_POST["cancel"])){header("Location: addstore.php");}
		
		if(isset($_GET["delete"]))
		{
			$sql = "DELETE FROM store WHERE product_id='".$_GET["id"]."'";
			mysql_query($sql,$con);
		}
		$result = mysql_query("SELECT * FROM store ORDER BY product_type");
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
	<form name="addstore" method="post" action="addstore.php" enctype="multipart/form-data">
    	<br/>
		<table>
        	<tr>
            	<td><img border="0" src = "images/text-ProductPic.PNG"/></td>
                <td><input name="fileUpload" type="file" /></td>
           	</tr>
        
			<tr>
				<td><img border="0" src = "images/text-ProductName.PNG"/></td>
                <td><input type="text" name="pname" value="<? if(!$pname && isset($_POST["submit"])){echo $_POST["pname"];}?>" /><? if($pname){echo "กรุณากรอกชื่อสินค้า";}?><? if($rep){echo "ชื่อสินค้าซ้ำกรุณาเปลี่ยนใหม่";}?></td>
            </tr>
            
            <tr>
				<td><img border="0" src = "images/text-ProductNum.PNG"/></td>
                <td><input type="text" name="amou" value="<? if(!$amou && isset($_POST["submit"])){echo $_POST["amou"];}?>" /><? if($amou){echo "กรุณากรอกจำนวนสินค้า";}?></td>
          	</tr>
            
            <tr>
				<td><img border="0" src = "images/text-ProductPrice.PNG"/></td>
                <td><input type="text" name="cost" value="<? if(!$cost && isset($_POST["submit"])){echo $_POST["cost"];}?>" /><? if($cost){echo "กรุณากรอกราคาสินค้า";}?></td>
         	</tr>
            
            <tr>
				<td><img border="0" src = "images/text-ProductCategory.PNG"/></td>
                <td><select size="1" name="type"><option value="clothing">เสื้อผ้า</option><option value="shoes">รองเท้า</option></select></td>
          	</tr>
            
            <tr>
				<td><img border="0" src = "images/text-ProductDescrib.PNG"/></td>
                <td><textarea name="detail" rows="3" cols="40"><? if(!$detail && isset($_POST["submit"])){echo $_POST["detail"];}?></textarea></td>
			</tr>
            
            <tr>
				<td colspan="2"><center><input type="submit" name="submit" value="Submit" style="background-color:#7fc1ff; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px" />
				<input type="reset" name="reset" value="Reset" style="background-color:#ff7fb5; border:0; color:#ffffff; font-weight:bold; height:25px; width:70px" /></center></td>
         	</tr>
        </table>
		<br/><hr /><br/>
		<table border="2" BORDERCOLOR="#ffffff">
        	<?
				 if($urep){echo "ชื่อสินค้าซ้ำกรุณาเปลี่ยนใหม่";}
				 if($upname){echo "กรุณากรอกชื่อสินค้า";}
				 if($uamou){echo "กรุณากรอกจำนวนสินค้า";}
				 if($ucost){echo "กรุณากรอกราคาสินค้า";}
			?>
			<tr BGCOLOR="7d430a" >
				
				<td><center><img border="0" src = "images/text-ProductCode2.PNG"/></center></td>
                <td><center><img border="0" src = "images/text-ProductPic2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductName2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductNum2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductPrice2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductCategory2.PNG"/></center></td>
				<td><center><img border="0" src = "images/text-ProductDescrib2.PNG"/></center></td>
                <td><center><img border="0" src = "images/text-Action.PNG"/></center></td>
				
			</tr>
		<? while($row = mysql_fetch_array($result))
			{?>
        		<tr BGCOLOR="fdd4ac">
					<td><? echo $row["product_id"];?></td>
                    
                    <td><img src="img/resize_<?=$row["product_img"];?>"></td>
					
                    <td><? if(isset($_GET["update"]) && $row["product_id"] == $_GET["id"]){?><input type="text" name="upname" value="<? echo $row["product_name"];?>" /><? }else{echo $row["product_name"];}?></td>
					
                    <td><? if(isset($_GET["update"]) && $row["product_id"] == $_GET["id"]){?><input type="text" name="uamou" value="<? echo $row["product_amount"];?>" /><? }else{echo $row["product_amount"];}?></td>
					
                    <td><? if(isset($_GET["update"]) && $row["product_id"] == $_GET["id"]){?><input type="text" name="ucost" value="<? echo $row["product_cost"];?>" /><? }else{echo $row["product_cost"];}?></td>
					
                    <td><? echo $row["product_type"];?></td>
					
                    <td><? if(isset($_GET["update"]) && $row["product_id"] == $_GET["id"]){?><textarea name="udetail" rows="3" cols="40"><? echo $row["product_detail"];}else{echo $row["product_detail"];}?></textarea></td>
					
                    <td><? if(isset($_GET["update"]) && $row["product_id"] == $_GET["id"]){?><input type="submit" name="update" value="Submit" /><input type="submit" name="cancel" value="Cancel" /><? }else{?><a href="addstore.php?update=true&id=<? echo $row["product_id"]?>" name="update">Update</a> <a href="addstore.php?delete=true&id=<? echo $row["product_id"]?>" name="delete" onclick="return confirm('Are you sure you want to delete?')">Delete</a><? }?></td>
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