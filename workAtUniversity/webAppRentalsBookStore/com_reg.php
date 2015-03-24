<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Register Completed</title>
    <link href="style.css" rel="stylesheet" type="text/css">
	<?
        session_start();
        if(isset($_SESSION['id']))
        {
            include('connect.php');
            $stmt = OCIParse($connection,"SELECT member_id FROM member WHERE member_id = ".$_SESSION['id']);
            OCIExecute($stmt);
            $row = oci_fetch_assoc($stmt);
            oci_free_statement($stmt);
            ocilogoff($connection);
            session_destroy();
        }
    ?>
    <script type="text/JavaScript">
        function timedout(timeoutPeriod)
        {
            setTimeout("window.location='logon.php';",timeoutPeriod);
        }
    </script>
</head>

<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="timedout(5000);">
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
        	<center>
                <br /><br /><img src="images/reg1.png" /><br />
                <img src="images/reg2.png" /><font face="BrowalliaUPC, CordiaUPC" color="#330000" size="7"><? if(isset($row['MEMBER_ID'])){echo $row['MEMBER_ID'];}?><br /></font>
                <img src="images/reg3.png" /><a href="logon.php"> <img src="images/back.png" /> </a><img src="images/reg4.png" /></h3>
            </center>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>