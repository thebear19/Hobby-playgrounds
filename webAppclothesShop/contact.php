<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact</title>
<link href="Script/search.css" type="text/css" rel="stylesheet" />
<?
	$con = mysql_connect("localhost:3306","root","") or die(mysql_error());
	mysql_select_db("pro",$con);
	mysql_query("SET NAMES UTF8");
	$result = mysql_query("SELECT * FROM store ORDER BY no ASC");
?>
<script type="text/javascript">
	var suggestions = new Array();
	<? for($i=0;$row = mysql_fetch_array($result);$i++){?>suggestions[<? echo $i;?>] = "<? echo $row["product_name"];?>";<? }?>
</script>
<script src="Script/search.js" type="text/javascript"></script>

<?
	if(isset($_POST["login"]))
	{
		$have = false;
		$md5 = $_POST["password"];
		for($i=0;$i<5;$i++){$md5 = md5($md5);}
		
		$sql = "SELECT * FROM members WHERE username='".$_POST["user"]."' AND password='$md5'";
		$result = mysql_query($sql,$con);
		if(mysql_num_rows($result) == 1){$have = true;}
		
		if($have)
		{
			$row = mysql_fetch_array($result);
			$_SESSION["logined"] = true;
			$_SESSION["role"] = $row["role"];
			$_SESSION["username"] = $row["username"];
		}
	}
?>

	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<BODY style="background-image: url(images/BG001.jpg);" bgproperties="fixed" onLoad="init();">
<center>
<div id="container">
<div id="header"></div>
<div id="horizontalnav">
	<div class="navlinks">
		<ul>	
			<li><a href="home.php"><img border="0" src = "images/buttom-Home.png" onmouseover="this.src= 'images/buttom-HomeW.png'" onmouseout="this.src='images/buttom-Home.png'" /></a></li>
			<li><a href="product.php"><img border="0" src = "images/buttom-Product.png" onmouseover="this.src= 'images/buttom-ProductW.png'" onmouseout="this.src='images/buttom-Product.png'" /></a></li>
			<li><a href="payment.php"><img border="0" src = "images/buttom-Payment.png" onmouseover="this.src= 'images/buttom-PaymentW.png'" onmouseout="this.src='images/buttom-Payment.png'" /></a></li>
			<li><a href="howto.php"><img border="0" src = "images/buttom-Howto.png" onmouseover="this.src= 'images/buttom-HowtoW.png'" onmouseout="this.src='images/buttom-Howto.png'" /></a></li>
			<li><a href="contact.php"><img border="0" src = "images/buttom-Contact.png" onmouseover="this.src= 'images/buttom-ContactW.png'" onmouseout="this.src='images/buttom-Contact.png'" /></a></li>
			<? if(!isset($_SESSION["logined"]))
        { ?>
			<li><a href="register.php"><img border="0" src = "images/buttom-Regis.png" onmouseover="this.src= 'images/buttom-RegisW.png'" onmouseout="this.src='images/buttom-Regis.png'" /></a></li>
			 <? }
		?>
		</ul>
	</div>
</div>
	
<div id="leftnav">
	<div class="ad280x300">
	<form name="myForm" method="post" action="" onsubmit="return validateForm()">
    	<? if(!isset($_SESSION["logined"]))
        { ?>
        <form name="login" action="home.php" method="post">	
			<div align=Left>
				<br/><img border="0" src = "images/text-LogIn.png"/><br/>
					
                <? if(empty($_POST["user"]) && isset($_POST["login"])){echo "กรุณากรอกชื่อผู้ใช้";}elseif(empty($_POST["password"]) && isset($_POST["login"])){echo "กรุณากรอกรหัสผ่าน";}elseif(isset($have) && isset($_POST["login"])){echo "รหัสผ่านผิดกรุณาแก้ไข";}?><br />
				
                &nbsp&nbsp&nbsp&nbsp<img border="0" src = "images/text-User.png"/><input type="text" name="user" value="" />
				<br/>&nbsp&nbsp&nbsp&nbsp<img border="0" src = "images/text-Pass.png"/><input type="password" name="password" value="" />
			</div>
			<br/><input type="submit" name="login" value ="Login" style="background-color:#fbdbe9; border:0; color:#ff0000; font-weight:bold; height:25px; width:70px" />
			<input type="reset" name="reset" value ="Reset" style="background-color:#fff799; border:0; color:#ff0000; font-weight:bold; height:25px; width:70px" /><br/>
       	</form>
        </br><a href="reset_password.php"><input type="button" name="forget" value ="Forgot Password" style="background-color:#b0e1de; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px" /></a>
		<a href="register.php"><input type="button" name="register" value ="Register" style="background-color:#c9e2a3; border:0; color:#ff0000; font-weight:bold; height:25px; width:70px"/></a>
     <? }
	   	else
		{?>
        	<br/>&nbsp&nbsp&nbsp&nbsp<font size=4 color=#000000><b><? echo "ยินดีต้อนรับคุณ &nbsp".$_SESSION["username"];?> </b></font><br /><br />
            
          <a href="logout.php"><input type="submit" name="logout" value ="Logout" style="background-color:#fbdbe9; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px"/></a>
			<br /><br /><a href="editpro.php"><input type="button" name="editpro" value ="Edit Profile" style="background-color:#b0e1de; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px" /></a>
            <br /><br /><a href="mycart.php"><input type="button" name="mycart" value ="My Cart" style="background-color:#c9e2a3; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px"/></a>
            <? if($_SESSION["role"] == "admin")
			{?>
            <br /><br /><a href="addstore.php"><input type="button" name="addstore" value ="Add Store" style="background-color:#daabf8; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px" /></a>
            <br /><br /><a href="checkorder.php"><input type="button" name="checkorder" value ="Check Order" style="background-color:#f8bfab; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px" /></a>
            <br /><br /><a href="checkpay.php"><input type="button" name="checkpay" value ="Check Pay" style="background-color:#fff799; border:0; color:#ff0000; font-weight:bold; height:25px; width:120px" /></a>
         <? }?>
     <? }?>
	</form>
	</div>
	<div class="leftnavs">
	<form name="myForm2" method="post" action="" onsubmit="return validateForm()">
		<div align=Left>
			<img border="0" src = "images/text-Search.png"/></br>
		</div>
    </form>
    
    <form name="search_system" id="search_system" action="product.php" method="get">
    	<input type="text" name="search" autocomplete="off">
		<input type="image" src = "images/buttom-Search.png" />
	</form>
    <div class="shadow" id="shadow">
	<div class="output" id="output">
	</div>
	</div>
        
		<br/><img border="0" src = "images/box-Contact.png"/>
		<br/></br><img border="0" src = "images/text-Product.png"/>
		<br/><a href="product.php?by=clothing"><img border="0" src = "images/text-ProductCloth2.png"  onmouseover="this.src= 'images/text-ProductCloth1.png'" onmouseout="this.src='images/text-ProductCloth2.png'" /></a>
		<br/><div align=right><a href="product.php"><img border="0" src = "images/text-SeeAll1.png"  onmouseover="this.src= 'images/text-SeeAll.png'" onmouseout="this.src='images/text-SeeAll1.png'" /></div></a>
		<div align=Center>
			
			<p><a target="_blank" href="http://track.thailandpost.co.th/trackinternet/">
			<img border="0" alt="µÃÇ¨ÊÍºÊ¶Ò¹Ð EMS áÅÐä»ÃÉ³ÕÂìÅ§·ÐàºÕÂ¹"  width="160" height="100" src="http://howto.readyplanet.com/images/column_1314330336/track_thailandpost.gif" /></a></p>
		</div>
	</div>
</div>

<div id="body">
<br/>
	<center>
		</br><img border="0" src = "images/text-ContactUs.png"/>	
	</center>
</div>

<div id="footer">
<font size="3" face="CordiaUPC" color="#FFFFFF">
<h4><b>copyright &copy; 2012 by BaFaPa Shop</b></h4>

</div>
</center>
</body>
</html>