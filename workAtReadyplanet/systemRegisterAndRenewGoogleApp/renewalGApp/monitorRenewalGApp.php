<!DOCTYPE html>
<html>
    <title>Monitor Google App</title>
    <head>
        <style type="text/css">
            th { background: #01BF76; }
            tr { border: none; }
            tr:hover td { background: #9DA0FF !important; }
            td {color: #000000}
        </style>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
        
        <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.css">
        <script type="text/javascript" charset="UTF-8" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        
        <script>
            $(document).ready(function(){
                $('#reportTable').DataTable();
            });
        </script>
    </head>
    <body>
        <?php
        include "resellerFunction.php";
        include "../inc_checkerror.php";
        
        $now = new DateTime("NOW");

        $service = new Google_Service_Reseller($client);

        $response = subscriptionList(1);
        $i = 1;
        
        krsort($response); //เรียงจากโดเมนเก่าสุด -> ใหม่สุด เนื่องจาก $response คืนมาเป็น ใหม่สุด -> เก่าสุด #user ไม่ชอบเลยแก้เพิ่ม

        echo "<table id='reportTable' class='table table-hover'>
                <thead><tr>
                    <th>No</th>
                    <th>Domain</th>
                    <th>numYear</th>
                    <th>numSeats</th>
                    <th>Reg Date</th>
                    <th>Start Date<br/>(เริ่มคิดเงิน)</th>
                    <th>Google Exp</th>
                    <th>Ready Exp</th>
                    <th>Status</th>
                    <th>Renewal Status</th>
                </tr></thead>";

        foreach ($response as $data) {
            $sql = " SELECT * FROM ready_googleapp a WHERE domain = '$data->customerId'";
            $query = mysql_db_query($dbname, $sql);
            $row = mysql_fetch_array($query);

            if ($data->plan->planName != 'TRIAL') {
                $color = ($i % 2 == 0) ? "#FFF392" : "#FFF7B2";
                echo "<tr>";
                echo "<td bgcolor='$color'>" . $i . "</td>";
                echo "<td bgcolor='$color'>" . $data->customerId . "</td>";
                echo "<td bgcolor='$color'>" . $row[numYears] . "</td>";
                echo "<td bgcolor='$color'>" . $data->seats->numberOfSeats . "</td>";
                echo "<td bgcolor='$color'>" . epochToDate($data->creationTime) . "</td>";
                echo "<td bgcolor='$color'>" . epochToDate($data->plan->commitmentInterval->startTime) . "</td>";
                echo "<td bgcolor='$color'>" . epochToDate($data->plan->commitmentInterval->endTime) . "</td>";
                
                $endReady = new DateTime($row['readyEndDate']);
                echo "<td bgcolor='$color'>" . $endReady->format('Y-m-d H:i:s') . "</td>";
                
                echo "<td bgcolor='$color'>" . $data->status . "</td>";
                
                if($data->plan->planName == "FLEXIBLE"){
                    $color = "#757373"; //สีเทา หมดอายุ
                }
                elseif ($data->renewalSettings->renewalType == 'SWITCH_TO_PAY_AS_YOU_GO') {
                    $interval = $endReady->diff($now); //= วันหมดอายุ - ปัจจุบัน
                    
                    if($interval->y == 0 && $interval->m < 3){
                        $color = "#E1E117"; //สีเหลือง ใกล้หมดอายุ มีรายการในระบบ grand แล้ว
                    }
                    else{
                        $color = $color;
                    }
                } else {
                    $interval = $endReady->diff($now);
                    $color = ($interval->y == 0) ? "#3917E1" : "#59310B";//น้ำเงิน(ต่ออายุ mannual) : น้ำตาล (ต่ออายุ auto)
                }
                
                echo "<td bgcolor='$color'>" . $data->renewalSettings->renewalType . "</td></tr>";
                $i++;
            }
        }
        echo "</table>";
        ?>
    </body>
</html>
