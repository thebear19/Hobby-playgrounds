<?php

session_start();
include("inc_dbconnect.php");

$sql = mysql_db_query($dbname, "SELECT pro_pcode FROM ready_product ORDER BY pid DESC LIMIT 0,1");
$row = mysql_fetch_array($sql);
preg_match_all('/\d+|[a-z]+/i', $row[pro_pcode], $pro_pcode);
$pro_pcode = $pro_pcode[0][0].++$pro_pcode[0][1]; //gen next pcode

$sql = "INSERT INTO ready_product 
        (pid,pname, pstatus,product_type_id,pro_pcode,pro_pcode_single,pro_acode,pro_price,pro_year,pro_desc,pro_order,qstatus, BOI, remark, pro_price_exclude_vat,effective_date_from,effective_date_to,step_price)
        VALUES
        ('','$pname', '$pstatus','$product_type_id','$pro_pcode','$pro_pcode','$pro_acode','$pro_price','$pro_year','$pro_desc','$pro_order','$qstatus','$BOI','','$pro_price_exclude_vat','$effective_date_from','NULL','$step_price')";

if (mysql_db_query($dbname, $sql)) {
    echo "Add Data Completed";
}
?>
