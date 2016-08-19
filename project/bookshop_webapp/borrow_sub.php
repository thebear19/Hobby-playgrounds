<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Borrow Submit</title>
    <link href="style.css" rel="stylesheet" type="text/css">
	<?
        session_start();
        include('connect.php');
        $stmt = OCIParse($connection,"SELECT borrow_id FROM borrow");
        OCIExecute($stmt);
        $id = oci_fetch_all($stmt,$result);
        $stmt = OCIParse($connection,"INSERT INTO borrow (BORROW_ID, BORROW_END, BORROW_DATE, MEMBER_ID) VALUES ('".($id+1)."',CURRENT_TIMESTAMP+14 ,CURRENT_TIMESTAMP , '".$_SESSION['user']."')");
        OCIExecute($stmt);
        oci_commit($connection);
        foreach ($_SESSION['store'] AS $store)
        {
            $stmt = OCIParse($connection,"SELECT book_id FROM book where isbn = '".$store."' and status = 'On shelf'");
            OCIExecute($stmt);
            if(oci_fetch_all($stmt,$result) == 1)
            {
                OCIExecute($stmt);
                $row = oci_fetch_assoc($stmt);
                $stmt = OCIParse($connection,"INSERT INTO borrow_line (BORROW_ID, BOOK_ID) VALUES ('".($id+1)."','".$row['BOOK_ID']."')");
                OCIExecute($stmt);
                oci_commit($connection);
                $stmt = OCIParse($connection,"UPDATE book SET status = 'Checked out' WHERE book_id = '".$row['BOOK_ID']."' and status = 'On shelf'");
                OCIExecute($stmt);
                oci_commit($connection);	
            }
        }
        $user = $_SESSION['user'];
        session_destroy();
        session_start();
        $_SESSION['user'] = $user;
    ?>
    <script type="text/JavaScript">
        function timedout(timeoutPeriod)
        {
            setTimeout("window.location='borrow.php';",timeoutPeriod);
        }
    </script>
</head>

<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="init();" onLoad="timedout(5000);">
	<center>
	<div id="container">
		<div id="header">
			<table border="0">
				<tr>
					<td width="320px"><img border="0" src = "images/LG1.png" /></td>
					<td width="800px" height="80px"><div align = "right">
						<?
                            
                            include('connect.php');
                            $_SESSION['sum'] = 0;
                            $_SESSION['i'] = 1;
                            if($_SESSION['user'] != "000000")
                            {
                                $stmt = OCIParse($connection,"SELECT firstname , lastname FROM member where member_id = ".$_SESSION['user']);
                                OCIExecute($stmt);
                                $row = oci_fetch_assoc($stmt);
                                $_POST['username'] = $row['FIRSTNAME']." ".$row['LASTNAME'];
                                oci_free_statement($stmt);
                                echo "<img border='0' src = 'images/welcome.png' /> คุณ ".$_POST['username']."  <a href='logout.php'><img border='0' src = 'images/logout.png' /></a>";
                            }
                        ?>
					</div></td>
				</tr>
			</table> 
		</div>
		<div id="horizontalnav">
	        <?php require("introduce.php"); ?>
		</div>
		<div id="body">
        	<center>
                <br /><br /><img src="images/H-sub.png" /><br />
                <img src="images/sub1.png" /><a href="borrow.php"> <img src="images/back.png" /> </a><img src="images/sub2.png" /></h3>
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