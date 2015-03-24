<?php

include("../inc_dbconnect.php");

$typeChange = explode("-", $_POST[typeChange]);
$type = $typeChange[0]; //index slot array
$group = $typeChange[1]; //mainType
$subGroup = $typeChange[2]; //subType

//check select data is being in main or sub
$table = ($group == $subGroup) ? "contact_detail_item" : "contact_detail_subitem";
$col = ($group == $subGroup) ? "TypeID" : "itemID";
$queryGroup = ($group == $subGroup) ? $typeChange[1] : $typeChange[2];

//create multiple update sql statment
$sql = "UPDATE $table SET sort = CASE sort ";
$newSort = 1;

foreach ($_POST[setData][$type] as $titleRow) {
    if(strpos($titleRow[name], $subGroup) === FALSE)
        continue;
    
    $ids[] = $newSort;
    $sql .= "WHEN $titleRow[id] THEN $newSort ";
    $newSort++;
}
$ids = implode(',', $ids);
$sql .= "END WHERE $col = '$queryGroup' && status != 2 && sort IN ($ids);";

echo $sql;
mysql_db_query($dbname, $sql);
?>