<?php

include ("../../inc_checkerror.php");
include("../../inc_dbconnectOOP.php");
include ("landing_report_db.php");
include("../report_utility.class.php");
include ("../report_clearing_controllerModel.php");
header('Content-Type: text/html; charset=TIS-620');


if (isset($_POST[type]) && ($_POST[type] == "search" || $_POST[type] == "load")) {
    
    $date = new DateTime($_POST[dateFrom]);
    $_POST[dateFrom] = $date->format("Y-m-d");
    $date = new DateTime($_POST[dateTo]);
    $_POST[dateTo] = $date->format("Y-m-d");

    
    if ($_POST[reportType] == 1) {
        
        landingReport($_POST[dateFrom], $_POST[dateTo], $dbConnect_a23);
    } if ($_POST[reportType] == 0) {
        
        clearingReport($_POST[dateFrom], $_POST[dateTo], $dbConnect_a23);
    } else {
        
        exit();
    }

    //print_r($dataReport);exit();
} elseif (isset($_POST[type]) && ($_POST[type] == "save" || $_POST[type] == "edit")) {
    
    $date = new DateTime($_POST[dateFrom]);
    $_POST[dateFrom] = $date->format("Y-m-d");
    $date = new DateTime($_POST[dateTo]);
    $_POST[dateTo] = $date->format("Y-m-d");
    $_POST[reportName] = iconv("utf-8", "tis-620", $_POST[reportName]);
    $_POST[reportDescription] = iconv("utf-8", "tis-620", $_POST[reportDescription]);
    $_POST[adminId] = $admin_id;

    $urlID = saveReport($_POST, $dbConnect_libra);

    if ($urlID) {

        echo "<p class='bg-success'>Saved complete.<br />
        You can access saved report by this url below.<br/>
        <a href='http://www.readyplanet.com/grandadmin/report/customize_report/customize_report_view.php?noReport=$urlID&accessType=view' target='_blank'>
                LINK</a></p>";
    } else {

        echo "<p class='bg-danger'>Error !!</p>";
    }
} elseif (isset($_POST[type]) && $_POST[type] == "listAllReport") {

    $superAdmin = array("Areesa", "Saran", "Chatchawan");


    $sql = "SELECT * FROM ready_saveform_report ORDER BY id ASC;";
    $query = $dbConnect_libra->query($sql);


    //table header
    echo "<table id='reportTable' class='table table-hover'>
        <thead><tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Date Range</th>
            <th>Action</th>
        </tr></thead>";


    //table body
    while ($row = $query->fetch_array()) {

        $no++;
        $row[name] = (empty($row[name])) ? "-" : $row[name];
        $row[description] = (empty($row[description])) ? "-" : $row[description];

        if ($row[type] == 0) {

            $row[type] = "Clearing";
        } elseif ($row[type] == 1) {

            $row[type] = "Landing";
        } elseif ($row[type] == 2) {

            $row[type] = "Leading";
        }

        $date = new DateTime($row[dateFrom]);
        $row[dateFrom] = $date->format("d-M-y");
        $date = new DateTime($row[dateTo]);
        $row[dateTo] = $date->format("d-M-y");


        $canAction = "<a href='http://www.readyplanet.com/grandadmin/report/customize_report/customize_report_view.php?noReport=$row[id]&accessType=view' target='_blank' style='color: #ffffff;' class='btn btn-primary col-sm-2' title='View'><i class='fa fa-eye'></i></a>";

        if (in_array($admin_name, $superAdmin) || $admin_id == $row[createBy]) {

            $canAction .= "<a href='http://www.readyplanet.com/grandadmin/report/customize_report/customize_report_view.php?noReport=$row[id]&accessType=edit' target='_blank' style='color: #ffffff;' class='btn btn-warning col-sm-2' title='Edit'><i class='fa fa-pencil'></i></a>
            <a href='#' name='deleteReport' style='color: #ffffff;' class='btn btn-danger col-sm-2' title='Delete' value='$row[id]'><i class='fa fa-trash-o'></i></a>";
        }


        echo "<tr>
            <td>$no</td>
            <td>$row[name]</td>
            <td>$row[description]</td>
            <td>$row[type]</td>
            <td>$row[dateFrom] <b>To</b> $row[dateTo]</td>
            <td>$canAction</td>
        </tr>";
    }

    echo "</table>";
} elseif (isset($_POST[type]) && $_POST[type] == "deleteReport") {
    
    $sql = "DELETE FROM ready_saveform_report WHERE id = '$_POST[noReport]';";
    $query = $dbConnect_libra->query($sql);

    if ($query) {

        echo "Delete completed.";
    } else {

        echo "Delete failed.";
    }
}




function saveReport($data, $dbConnect_libra) {

    if ($data[type] == "save") {
        
        $sql = "INSERT INTO ready_saveform_report (dateFrom, dateTo, name, description, config, type, createBy)
            VALUES ('$data[dateFrom]', '$data[dateTo]', '$data[reportName]', '$data[reportDescription]', '$data[config]', '$data[reportType]', '$data[adminId]');";
    } else {
        
        $sql = "UPDATE ready_saveform_report SET
                    dateFrom = '$data[dateFrom]',
                    dateTo = '$data[dateTo]',
                    name = '$data[reportName]',
                    description = '$data[reportDescription]',
                    config  = '$data[config]',
                    type = '$data[reportType]'
                    WHERE id = '$data[noReport]';";
    }

    
    $query = $dbConnect_libra->query($sql);

    
    if ($query) {
        
        if ($data[type] == "save") {
            
            return $dbConnect_libra->insert_id;
        } else {
            
            return $data[noReport];
        }
    } else {
        
        return 0;
    }
}


function landingReport($dateFrom, $dateTo, $dbConnect_a23) {
    
    $objReport = new landingReport($dbConnect_a23);
    $dataReport = $objReport->getReport($dateFrom, $dateTo);
    
    echo "<table id='pivot'>
            <thead>
                <tr>
                    <th>product</th>
                    <th>source</th>
                    <th>medium</th>
                    <th>campaign</th>
                    <th>status</th>
                    <th>country</th>
                    <th>sale</th>
                    <th>sale_status</th>
                    <th>sale_team</th>";


    echo "<th>product2</th>
                    <th>product3</th>
                    <th>status2</th>
                    <th>status3</th>
                    
                    <th>Landing_url</th>
                    <th>id</th>
                    <th>C_id</th>";

    echo "<th>C_status</th>
                </tr>
            </thead><tbody>";




    foreach ($dataReport as $value) {
        echo "<tr>
                <td>$value[product]</td>
                <td>$value[source]</td>
                <td>$value[medium]</td>
                <td>$value[campaign]</td>
                <td>$value[status]</td>
                <td>$value[country]</td>
                <td>$value[sale]</td>
                <td>$value[saleStatus]</td>
                <td>$value[saleTeam]</td>";


        echo "<td>$value[product2]</td>
                <td>$value[product3]</td>
                <td>$value[status2]</td>
                <td>$value[status3]</td>
                    
                <td>$value[Landing_url]</td>
                <td>$value[id]</td>
                <td>$value[Cid]</td>";

        echo "<td>$value[statusCustomer]</td>
            </tr>";
    }

    echo "</tbody></table>";
}


function clearingReport($dateFrom, $dateTo, $dbConnect_a23) {
    
    $objReport = new ClearingModel($dbConnect_a23);
    $obj = $objReport->getReport($dateFrom, $dateTo);

    echo "<table id='pivot'>
            <thead>
                <tr>
                    <th>newmemberid</th>
                    <th>amount</th>
                    <th>product_name</th>
                    <th>product_sku</th>
                    <th>product_cat</th>
                    <th>product_costtype</th>
                    <th>customer_id</th>
                    <th>customer_name</th>
                    <th>country</th>
                    <th>sale_name</th>
                    <th>sale_team</th>
                    <th>clientId</th>
                    <th>landing_product</th>
                    <th>landing_url</th>
                    <th>landing_date</th>
                    <th>landing_year</th>
                    <th>landing_month</th>
                    <th>landing_day</th>
                    <th>clearing_date</th>
                    <th>date_diff_months</th>
                    <th>date_diff_days</th>
                </tr>
            </thead>
        <tbody>";
    foreach ($obj as $value) {
        //$pname = iconv("tis-620", "utf-8", $value[product_name]);
        //$cname = iconv("tis-620", "utf-8", $value[customer_name]);
        $pname = $value[product_name];
        $cname = $value[customer_name];
        
        echo "<tr>
                <td>$value[newmemberid]</td>
                <td>$value[amount]</td>
                <td>$pname</td>
                <td>$value[product_sku]</td>
                <td>$value[product_cat]</td>
                <td>$value[product_costtype]</td>
                <td>$value[customer_id]</td>
                <td>$cname</td>
                <td>$value[customer_country]</td>
                <td>$value[sale_name]</td>
                <td>$value[sale_team]</td>
                <td>$value[clientid]</td>
                <td>$value[landing_product]</td>
                <td>$value[landing_url]</td>
                <td>$value[landing_time]</td>
                <td>$value[landing_year]</td>
                <td>$value[landing_month]</td>
                <td>$value[landing_day]</td>
                <td>$value[clearing_date]</td>
                <td>$value[date_diff_m]</td>
                <td>$value[date_diff_d]</td>
            </tr>";
    }
    echo "</tbody></table>";
}
?>