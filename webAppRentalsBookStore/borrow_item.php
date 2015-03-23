<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>List</title>
   	<link href="style.css" rel="stylesheet" type="text/css">
	<?
		session_start();
        include('connect.php');
        $stmt = OCIParse($connection,"SELECT member_id FROM borrow where borrow_id = ".$_GET['target']." ORDER BY borrow_id ASC");
        OCIExecute($stmt);
        $id = oci_fetch_assoc($stmt);
        $stmt = OCIParse($connection,"SELECT * FROM member where member_id = ".$id['MEMBER_ID']);
        OCIExecute($stmt);
        $id = oci_fetch_assoc($stmt);
        $st = OCIParse($connection,"SELECT book_id FROM borrow_line where borrow_id = ".$_GET['target']);
        OCIExecute($st);
    ?>
</head>

<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="init();">
	<center>
	<div id="container">
		<div id="header">
			<table border="0">
				<tr>
					<td width="320px"><img border="0" src = "images/LG1.png" /></td>
					<td width="800px" height="80px"><div align = "right">
					<? if($_SESSION['user'] === "000000"){
                    	echo "<img border='0' src = 'images/welcome.png' /> คุณ admin   <a href='logout.php'><img border='0' src = 'images/logout.png' /></a>";
					}?>
					</div></td>
				</tr>
			</table> 
		</div>
		<div id="horizontalnav">
        	<table border="0">
				<tr>
					<td width="10px"></td>
					<td width="1018px">
                    	<ul id="paneltwo">  
							<li class="mask"><center><img border="0" src = "images/L-menu.png" /></center></li>  
							<li class="linkOne"><a href="member.php"><center><img border="0" src = "images/L-member.png"/></center></a></li>  
							<li class="linkTwo"><a href="book.php"><center><img border="0" src = "images/L-book.png"/></center></a></li>  
							<li class="linkThree"><a href="borrow_list.php"><center><img border="0" src = "images/L-borrow.png"/></center></a></li>  
							<li class="linkFour"><a href="return.php"><center><img border="0" src = "images/L-return.png"/></center></a></li>  
						</ul>
                 	</td>
				</tr>
			</table> 
			
		</div>
		<div id="body"> 
            <center>
		        <br/><img border="0" src = "images/H-details.png" /><br/><br/>
                <font face="BrowalliaUPC, CordiaUPC" size="4">
                <table>
                    <tr>
                        <td><img border="0" src = "images/T-memname.png" /></td>
                        <td><font size="5"><b><? echo $id['FIRSTNAME']." ".$id['LASTNAME']; ?></b></font></td>
                    </tr>
                 </table><br />
                <table border="1" bordercolor="#00bfcb" bgcolor="#eafdde">
                    <tr>
                        <th width = "150" height="40" align="center" bgcolor="#23f2b5"><font size="5"><b>Book Name</b></font></th>
                        <th width = "150" height="40" align="center" bgcolor="#23f2b5"><font size="5"><b>Author</b></font></th>
                        <th width = "150" height="40" align="center" bgcolor="#23f2b5"><font size="5"><b>Publisher</b></font></th>
                        <th width = "150" height="40" align="center" bgcolor="#23f2b5"><font size="5"><b>ISBN</b></font></th>
                    </tr>
                    <?
                        while($row = oci_fetch_assoc($st))
                        {
                            $stmt = OCIParse($connection,"SELECT * FROM book where book_id = ".$row['BOOK_ID']);
                            OCIExecute($stmt);
                            $show = oci_fetch_assoc($stmt);
                            echo "<tr><td align='center'>".$show['BOOK_NAME']."</td>
                                  <td align='center'>".$show['AUTHOR']."</td>
                                  <td align='center'>".$show['PUBLISHER']."</td>
                                  <td align='center'>".$show['ISBN']."</td></tr>";
                        }
                    ?>
                </table>
                <br /><a href="borrow_list.php"><img border="0" src = "images/back.png" /></a>
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