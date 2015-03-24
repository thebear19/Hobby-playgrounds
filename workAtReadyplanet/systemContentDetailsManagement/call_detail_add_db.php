<?php

session_start();
include ("../inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

$allowType = array('application/pdf',
    'application/octet-stream',
    'application/vnd.ms-word',
    'application/vnd.openxmlformats',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/excel',
    'application/vnd.ms-excel',
    'application/msexcel',
    'application/msword',
    'application/zip',
    'application/x-zip'
); //PDF,XLS,XLSX,DOC,DOCX

$_POST[name] = iconv("UTF-8", "TIS-620", $_POST[name]);

if ($_POST[type] == 'file') {
    $allContent = "<table width=\"780\" style=\"border:0px solid #555555;margin:0 0 0 10;\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">";

    foreach ($_FILES as $key => $file) {
        if ($file["error"] == UPLOAD_ERR_OK) {
            $allContent .= "<tr><td colspan = \"2\" align = \"center\">";

            if ($file["type"] == "image/jpeg") {
                $linkIMG = "http://www.readyplanet.com/images/new_package/$file[name]";
                $allContent .= "<img src =\"$linkIMG\" />";

                copy($file['tmp_name'], '/home/grandplanet/www/_readyplanetcom/images/new_package/' . $file["name"]);
            } elseif (in_array($file["type"], $allowType)) {
                $linkPDF = "http://www.readyplanet.com/PDF/$file[name]";
                $allContent .= "<a href =\"$linkPDF\" target =\"_blank\"><b>$_POST[name]</b></a>";

                copy($file['tmp_name'], '/home/dev01/2010_readyplanet_com/PDF/' . $file["name"]);
            }

            $allContent .= "</td></tr>";
        } elseif ($file["error"] != UPLOAD_ERR_NO_FILE) {
            echo "Upload error : $file[name]<br/>";
            exit();
        }
    }

    $allContent .= "</table>";
} else {
    $allContent = iconv("UTF-8", "TIS-620", $_POST[htmlCode]);
}
$tableIn = ($_POST[subTypeContent] == '') ? "contact_detail_item" : "contact_detail_subitem";
$colIn = ($_POST[subTypeContent] == '') ? "TypeID" : "itemID";
$idIn = ($_POST[subTypeContent] == '') ? $_POST[typeContent] : $_POST[subTypeContent];

$countLast = mysql_fetch_array(mysql_db_query($dbname, "SELECT MAX( ID ) as max FROM $tableIn"));
$countSort = mysql_fetch_array(mysql_db_query($dbname, "SELECT MAX( sort ) as max FROM $tableIn where $colIn = $idIn && status = 1 "));
$countLast = $countLast[max] + 1;
$countSort = $countSort[max] + 1;

if (isset($_POST[isEdit]) && $_POST[isEdit] == 1) {
    $sql = "UPDATE $tableIn SET
            $colIn = '$idIn',
            Detail = '$_POST[name]',
            linkPDF = '$linkPDF',
            comment = '$_POST[name]',
            previewContent = '$allContent',
            sendmailContent = '$allContent'
            WHERE Name = '$_POST[varName]'";
} else {
    $sql = "INSERT INTO $tableIn ($colIn, Name, Detail, linkPDF, comment, previewContent, sendmailContent, sort)
        VALUES ('$idIn', 'T" . $idIn . "_" . $countLast . "', '$_POST[name]', '$linkPDF', '$_POST[name]', '$allContent', '$allContent', '$countSort');";
}

if (mysql_db_query($dbname, $sql)) {
    echo "Process completed";
} else {
    echo $sql;
    echo "Process Error!!";
}
?>