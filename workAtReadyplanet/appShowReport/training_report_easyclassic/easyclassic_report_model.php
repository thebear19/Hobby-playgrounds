<?php
include ("../../inc_checkerror.php");
include("../../inc_dbconnectOOP.php");
include ("easyclassic_report_db.php");
header('Content-Type: text/html; charset=TIS-620');
$objReport = new easyClassicReport($dbConnect_a23, $dbConnect_libra);

if (isset($_POST[type]) && $_POST[type] == "search") {
    $date = new DateTime($_POST[dateFrom]);
    $_POST[dateFrom] = $date->format("Y-m-d");
    $date = new DateTime($_POST[dateTo]);
    $_POST[dateTo] = $date->format("Y-m-d");
    
    $dataReport = $objReport->getReport($_POST);

    //print_r($dataReport);exit();
    
    $showData =  "<table id='reportTable' class='table table-hover'>
                    <thead><tr>
                        <th>URL</th>
                        <th>Type</th>
                        <th>Course</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Register Date</th>
                        <th>Attend Status</th>
                    </tr></thead>";

        foreach ($dataReport as $data) {
            $showData .= "<tr>
                            <td><a href='../../../page_redirecting.php?URL=http://www.$data[url]' target='_blank'>$data[url]</a></td>
                            <td>$data[type]</td>
                            <td>$data[course]</td>
                            <td>$data[classNo]</td>
                            <td>$data[name]</td>
                            <td>$data[email]</td>
                            <td>$data[phone]</td>
                            <td>$data[registerDate]</td>
                            <td>$data[attendClass]</td>
                        </tr>";
        }
        $showData .= "</table>";
        
        echo $showData;
}
elseif (isset($_POST[type]) && $_POST[type] == "option") {
    echo $objReport->getOptionCourse();
}
?>