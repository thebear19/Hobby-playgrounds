<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Book Store</title>
   	<link href="style.css" rel="stylesheet" type="text/css">
	<?
        session_start();
        include('connect.php');
        $stmt = OCIParse($connection,"SELECT * FROM book ORDER BY book_id ASC");
        OCIExecute($stmt);
        if(isset($_POST['submit']))
        {
            if($_POST['isbn'] != "" && $_POST['book_name'] != "" && $_POST['book_price'] != "" && $_POST['status'] != "" && $_POST['borrow_price'] != "" && $_POST['purchased_price'] != "" && $_POST['fine_rate'] != "")
            {
                if(is_numeric($_POST['isbn']) && is_numeric($_POST['book_price']) && is_numeric($_POST['borrow_price']) && is_numeric($_POST['purchased_price']) && is_numeric($_POST['fine_rate']))
                {
                    $stmt = OCIParse($connection,"UPDATE book SET isbn = '".$_POST['isbn']."',book_name = '".$_POST['book_name']."',author = '".$_POST['author']."',publisher = '".$_POST['publisher']."',book_price = '".$_POST['book_price']."',status = '".$_POST['status']."',borrow_price = '".$_POST['borrow_price']."',purchased_price = '".$_POST['purchased_price']."',soure_of_book = '".$_POST['soure']."',fine_rate = '".$_POST['fine_rate']."' WHERE book_id = '".$_GET['target']."'");
                    OCIExecute($stmt);
                    oci_commit($connection);
                    oci_free_statement($stmt);
                    ocilogoff($connection);
                    header("Location: book.php");
                }else{$_SESSION['error'] = "ข้อมูลต้องเป็นตัวเลขเท่านั้น";}
            }
            else{$_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";}
        }
        elseif(isset($_GET['delete']))
        {
            $stmt = OCIParse($connection,"DELETE FROM book WHERE book_id = '".$_GET['target']."'");
            OCIExecute($stmt);
            oci_commit($connection);
            oci_free_statement($stmt);
            ocilogoff($connection);
            header("Location: book.php");
        }
    
        if(isset($_POST['submit_add']))
        {
            if($_POST['isbn'] != "" && $_POST['book_name'] != "" && $_POST['book_price'] != "" && $_POST['status'] != "" && $_POST['borrow_price'] != "" && $_POST['purchased_price'] != "" && $_POST['fine_rate'] != "")
            {
                if(is_numeric($_POST['isbn']) && is_numeric($_POST['book_price']) && is_numeric($_POST['borrow_price']) && is_numeric($_POST['purchased_price']) && is_numeric($_POST['fine_rate']))
                {
                    $stmt = OCIParse($connection,"SELECT book_id FROM book");
                    OCIExecute($stmt);
                    $id = oci_fetch_all($stmt,$result);
                    $stmt = OCIParse($connection,"INSERT INTO book (BOOK_ID, ISBN, BOOK_NAME, AUTHOR, PUBLISHER, BOOK_PRICE, STATUS, BORROW_PRICE, PURCHASED_DATE, PURCHASED_PRICE, SOURE_OF_BOOK, FINE_RATE) values ('".($id+1)."','".$_POST['isbn']."','".$_POST['book_name']."','".$_POST['author']."','".$_POST['publisher']."','".$_POST['book_price']."','".$_POST['status']."','".$_POST['borrow_price']."',CURRENT_TIMESTAMP,'".$_POST['purchased_price']."','".$_POST['soure']."','".$_POST['fine_rate']."')");
                    OCIExecute($stmt);
                    oci_commit($connection);
                    oci_free_statement($stmt);
                    ocilogoff($connection);
                    header("Location: book.php");
                }else{$_SESSION['error'] = "ข้อมูลต้องเป็นตัวเลขเท่านั้น";}
            }
            else{$_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";}
        }
    ?>
    <script type="text/javascript">
        function add_book()
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
            xmlhttp.open("POST","book_add.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send();
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
			<? 
                if(isset($_SESSION['error']))
                {
                    echo "<center><font color='#FF0000'>".$_SESSION['error']."</font></center>";
                    unset($_SESSION['error']);
                }
            ?>
            <div id="target"> &nbsp; </div>
            <form id='form' name='form' method='post' action='' >
                <div align = "right"> <button type="button" id="add" name="add" value="Add" onclick="add_book()" /><img border="0" src = "images/add.png" /></button> </div> 
                <center> <br/><font face="BrowalliaUPC, CordiaUPC" size="4">
                <table border="0">
                    <tr><td width = "5"></td><td width = "1000"><table border="1" bordercolor="#00bfcb" bgcolor="#eafdde"><tr>
              
                        <th width = "15" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>ID</b></font></th>
                        <th width = "50" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>ISBN</b></font></th>
                        <th width = "150" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Name</b></font></th>
                        <th width = "80" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Author</b></font></th>
                        <th width = "100" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Publisher</b></font></th>
                        <th width = "30" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Book Price</b></font></th>
                        <th width = "30" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Status</b></font></th>
                        <th width = "30" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Borrow Price</b></font></th>
                        <th width = "50" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Purchased Date</b></font></th>
                        <th width = "30" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Purchased Price</b></font></th>
                        <th width = "80" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Soure Of Book</b></font></th>
                        <th width = "30" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Fine Rate</b></font></th>
                        <th width = "50" height="40" align="center" bgcolor="#23f2b5"><font size="4"><b>Action</b></font></th>
                        <?
                            while($row = oci_fetch_assoc($stmt))
                            {
                                echo "<tr><td align='center'>".$row['BOOK_ID']."</td>\n";
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='isbn' value='".$row['ISBN']."' style='background-color:#dadada; border:0; width:100px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['ISBN']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='book_name' value='".$row['BOOK_NAME']."' style='background-color:#dadada; border:0; width:120px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['BOOK_NAME']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='author' value='".$row['AUTHOR']."' style='background-color:#dadada; border:0; width:70px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['AUTHOR']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='publisher' value='".$row['PUBLISHER']."' style='background-color:#dadada; border:0; width:80px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['PUBLISHER']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='book_price' value='".$row['BOOK_PRICE']."' style='background-color:#dadada; border:0; width:30px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['BOOK_PRICE']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><select name='status' size='1'  style='background-color:#dadada; border:0; width:80px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'><option>";
                                    if($row['STATUS'] == "On shelf"){echo $row['STATUS'];}else{echo "Checked out";}
                                    echo "</option><option>";
                                    if($row['STATUS'] == "On shelf"){echo "Checked out";}else{echo "On shelf";}
                                    echo "</option></select></td>\n";
                                }else{echo "<td>".$row['STATUS']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='borrow_price' value='".$row['BORROW_PRICE']."' style='background-color:#dadada; border:0; width:50px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['BORROW_PRICE']."</td>\n";}
                                
                                echo "<td align='center'>".$row['PURCHASED_DATE']."</td>\n";
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='purchased_price' value='".$row['PURCHASED_PRICE']."' style='background-color:#dadada; border:0; width:50px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['PURCHASED_PRICE']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='soure' value='".$row['SOURE_OF_BOOK']."' style='background-color:#dadada; border:0; width:200px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['SOURE_OF_BOOK']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='text' name='fine_rate' value='".$row['FINE_RATE']."' style='background-color:#dadada; border:0; width:50px; color:#492301; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['FINE_RATE']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['BOOK_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='image' name='submit' value='Submit' src = 'images/submit.png'/></a>
                                          <a href='book.php'><img src = 'images/cancel.png' /></a></td></tr>\n";
                                }
                                else
                                {
                                    echo "<td align='center'><a href='book.php?edit=true&target=".$row['BOOK_ID']."'><img src = 'images/edit.png' /></a>"; ?>
                                          <a href="book.php?delete=true&target=<? echo $row['BOOK_ID']?>" name="delete" onclick="return confirm('ต้องการที่จะลบข้อมูลนี้หรือไม่?')"><img border="0" src = "images/delete.png" /></a><? echo"</td></tr>\n";
                                }
                            }
                        ?>
                    </tr></table></td><td width = "5"></td></tr>
                </table></font>
                </center>
                <br/><div align = "right"> <button type="button" id="add" name="add" value="Add" onclick="add_book()" /><img border="0" src = "images/add.png" /></button> 
                <a href="book.php"><img border="0" src = "images/up.png" /></a></div> <br/>
            </form>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>