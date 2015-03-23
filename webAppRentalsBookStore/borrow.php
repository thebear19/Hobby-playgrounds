<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borrow Book</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function borrow_book()
        {
            var xmlhttp;
            if(window.XMLHttpRequest)
            {
                xmlhttp = new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function()
            {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("target").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("POST","borrow_book.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("book="+document.form.book.value);
        }
        function check_book()
        {
            if(document.form.book.value != ""){borrow_book();}else{alert("กรุณากรอกรหัสหนังสือ")}
        }
    </script>
</head>
<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="init();">
	<center>
	<div id="container">
		<div id="header">
			<table border="0">
				<tr>
					<td width="320px"><img border="0" src = "images/LG1.png" /></td>
					<td width="800px" height="80px"><div align = "right">
						<?
                            session_start();
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
			<? if(isset($_POST['username'])){?>
            <form id='form' name='form' method='post' action='' >
                <center>
                	<br/><img border="0" src = "images/H-borrow.png" /><br/><br/>
                    <table>
                        <tr>
                            <td><img border='0' src = 'images/T-isbn.png' /></td>
                            <td><input type="text" name="book" 
                            style="background-color:#eafbff; border:0; width:130px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                            <td><input type="button" name="add" value="Add"  onclick="check_book()" 
                            style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                        </tr>
                    </table>
                    <br/>
                </center>
            </form>
            <div id="target"> &nbsp; </div>
            <? }else{header("Location: return.php");} ?>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>