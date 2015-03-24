<?php
session_start();
include "../inc_dbconnect.php";
include "../inc_checkerror.php";
include "../inc_show_admin_name.php";
include "../ReadyProduct.class.php";
header('Content-Type: text/html; charset=TIS-620');

if (isset($_POST['search'])) {
    $objProd = new ReadyProduct($dbname);

    if (!empty($_POST[dateFrom]) && !empty($_POST[dateTo])) {
        $date = "AND a.AppliedDate >= '$_POST[dateFrom]' AND a.AppliedDate <= '$_POST[dateTo]'";
    } elseif (!empty($_POST[dateFrom]) && empty($_POST[dateTo])) {
        $date = "AND a.AppliedDate >= '$_POST[dateFrom]' AND a.AppliedDate <= NOW()";
    } elseif (empty($_POST[dateFrom]) && !empty($_POST[dateTo])) {
        $date = "AND a.AppliedDate >= '2014-01-01' AND a.AppliedDate <= '$_POST[dateTo]'";
    } else {
        $date = "AND DATEDIFF (a.AppliedDate, NOW()) <= '-3' AND a.AppliedDate >= '2014-01-01'";
    }

    $sql = "SELECT a.*, b.Sale as saleID FROM ready_new_members a 
        INNER JOIN ready_customer_id b 
        ON a.CustomerID = b.CustomerID
        WHERE a.status > '0' AND a.contact_status = '0' AND a.CustomerID != '0' AND b.OrgStruct = '$_POST[country]' AND
        (
            (a.landing_url LIKE '%facebook%.readyplanet.com%')
            OR (a.Product_Description LIKE 'XA' AND a.Remark LIKE '%คำค้น%')
            OR (a.product_type = '4')
        )
        $date ORDER BY a.ID ASC;";

    $query = mysql_db_query($dbname, $sql);


    echo "<div id='result'><table id='reportTable' class='table table-bordered'>
                <thead><tr>
                    <th>No</th>
                    <th>Apply</th>
                    <th>Expire</th>
                    <th>Time</th>
                    <th>Web Name</th>
                    <th>Cus.ID</th>
                    <th>Sale</th>
                    <th>Secondary Sale</th>
                    <th>Enterprise</th>
                    <th>Product</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Tel</th>
                </tr></thead>";

    while ($row = mysql_fetch_array($query)) {
        $dateApp = new DateTime($row[AppliedDate]);
        $dateExp = new DateTime($row[ExpiredDate]);

        $time = substr($row[Datetime], 8);
        $second = substr($time, 4);
        $minute = substr($time, 2, 2);
        $hour = substr($time, 0, 2);

        if(empty($row[Sale])){
            $s_id = (empty($row[saleID]) || $row[saleID] == 99) ? 0 : $row[saleID];
        }else{
            $s_id = ($row[Sale] == 99) ? 0 : $row[Sale];
        }

        if (!$objProd->setProNameNew($row[ID])) {
            $objProd->setProName($row[Product_Description], $row[RegisYear]);
        }
        $pro_name = $objProd->getProName();

        echo "<tr>
                    <td>$row[ID]</td>
                    <td>" . $dateApp->format("d/m/Y") . "</td>
                    <td>" . $dateExp->format("d/m/Y") . "</td>
                    <td>$hour:$minute:$second</td>
                    <td>$row[DomainName]</td>
                    <td>$row[CustomerID]</td>
                    <td>$arr_salesname[$s_id]</td>
                    <td>$row[secondarySaleName]</td>
                    <td>$row[baiduSaleName]</td>
                    <td>$pro_name</td>
                    <td>$row[FirstName] $row[LastName]</td>
                    <td>$row[Email]</td>
                    <td>$row[Phone]</td>
                </tr>";
    }

    echo "</table></div>";

    exit();
}
?>
<!DOCTYPE html>
<html>
    <title>No Contact Report</title>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
        <script type="text/javascript" charset="TIS-620" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function () {
                $("button[name='search']").click(function () {
                    ajaxResult();
                });
            });

            function ajaxResult() {
                $("button[name='search']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='search']").attr("disabled", "disabled");

                //ajax call
                $.post("report_noContact.php",
                        {
                            search: "",
                            dateFrom: $("input[name='dateFrom']").val(),
                            dateTo: $("input[name='dateTo']").val(),
                            country: $("select[name='country']").val()
                        }
                )
                        .done(function (data) {
                            $("button[name='search']").html("Search");
                            $("button[name='search']").removeAttr("disabled");

                            $("#result").html(data);
                            $('#reportTable').DataTable();
                        });
            }
        </script>

        <style type="text/css">
            tr:hover td { background: #9DA0FF !important; }
        </style>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>No Contact Landing Report</h2></div>

            <div class="form-group">
                <label class="control-label col-sm-4">Date:</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="dateFrom" />
                </div>

                <div class="col-sm-2">
                    <input type="date" class="form-control" name="dateTo" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Country:</label>
                <div class="col-sm-4">
                    <select name="country" class="form-control">
                        <option value="0">Thailand</option>
                        <option value="1">Myanmar</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <button name="search" class="btn btn-default">Search</button>
                </div>
            </div>
        </div>

        <br/><br/>
        <div id="result"></div>
    </body>
</html>