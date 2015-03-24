<?php
session_start();
include "../inc_dbconnect.php";
include "../inc_checkerror.php";
header('Content-Type: text/html; charset=TIS-620');

$sql = "SELECT a.*, b.tax_invoice, b.newmemberid FROM ready_account_bank_statement a
        LEFT OUTER JOIN ready_office_clearing b 
        ON b.newmemberid = a.clearing_no 
        WHERE a.status = '0'
        ORDER BY a.s_id DESC";

$query = mysql_db_query($dbname, $sql);

function checkPaymentBy($pay_id) {
    global $dbname;
    $sql_payment = "SELECT * FROM ready_account_payment WHERE pay_id='$pay_id'";
    $se_payment = mysql_db_query($dbname, $sql_payment);
    $re_payment = mysql_fetch_array($se_payment);
    $payment_by = $re_payment[payment_by];
    return $payment_by;
}
?>
<!DOCTYPE html>
<html>
    <title>Pending Bank Statment Report</title>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
        
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
        <script type="text/javascript" charset="TIS-620" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function () {
                $('#reportTable').DataTable();
            });
        </script>
        
        <style type="text/css">
            tr:hover td { background: #9DA0FF !important; }
        </style>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Bank Statment(No Finish) Report</h2></div>
        </div>
        
        <?php
        echo "<div id='result'><table id='reportTable' class='table table-bordered'>
                <thead><tr>
                    <th align='center'>No</th>
                    <th align='center'>Bank</th>
                    <th align='center'>ช่องทางการชำระเงิน</th>
                    <th align='center'>Reference No</th>
                    <th align='center'>Date</th>
                    <th align='center'>เข้า</th>
                    <th align='center'>ออก</th>
                </tr></thead>";
        
        $num = 1;
        while ($row = mysql_fetch_array($query)) {
            echo "<tr>
                    <td align='center'>$num</td>
                    <td align='center'>$row[bank]</td>
                    <td align='center'>" . checkPaymentBy($row[pay_by]) . "</td>
                    <td align='center'>$row[ref_no]</td>
                    <td align='center'>" . date("d/m/Y", strtotime($row[pay_date])) . "</td>
                    <td align='right'>" . number_format($row[pay_in], 2, '.', ',') . "</td>
                    <td align='right'>" . number_format($row[pay_out], 2, '.', ',') . "</td>
                </tr>";
            
            $num++;
        }

        echo "</table></div>";
        ?>
    </body>
</html>