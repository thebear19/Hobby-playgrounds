<?php
include("../inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');
if($_POST[deleteItem]){
    $query = mysql_db_query($dbname, "SELECT * FROM contact_detail_item WHERE Name = '$_POST[deleteItem]' && status != 2");
    $num = mysql_num_rows($query);
    if ($num == 0) {
        $query = mysql_db_query($dbname, "SELECT * FROM contact_detail_subitem WHERE Name = '$_POST[deleteItem]' && status != 2");
        $num = mysql_num_rows($query);
        if($num == 0){
            echo "ERROR : Not Found";
        }else{
            $row = mysql_fetch_array($query);
            $status = ($row[status]) ? 0 : 1;
            $query = mysql_db_query($dbname, "UPDATE contact_detail_subitem SET status = '$status' WHERE Name = '$_POST[deleteItem]' && status != 2");
        }
    }else{
        $row = mysql_fetch_array($query);
        $status = ($row[status]) ? 0 : 1;
        $query = mysql_db_query($dbname, "UPDATE contact_detail_item SET status = '$status' WHERE Name = '$_POST[deleteItem]' && status != 2");
    }
    
    if($query){
        echo ($row[status]) ? "$row[Detail] : Unavailable" : "$row[Detail] : Available";
    }
}
?>
