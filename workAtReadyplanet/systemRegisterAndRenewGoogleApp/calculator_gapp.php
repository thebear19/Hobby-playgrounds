<?php
session_start();
include ("../inc_checkerror.php");
include ("../inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

if (isset($_POST[search])) {
    $sql = "SELECT * FROM ready_googleapp WHERE domain LIKE '%$_POST[domain]%' LIMIT 0,1;";
    $query = mysql_db_query($dbname, $sql);

    if (mysql_num_rows($query) == 0) {
        echo json_encode(array('error' => array('message' => "Domain not found.")));
        exit();
    }

    $row = mysql_fetch_array($query);

    $row[readyEndDate] = new DateTime($row[readyEndDate]);
    $row[readyEndDate] = $row[readyEndDate]->format("Y-m-d");

    echo json_encode(array("results" => array('numYears' => $row[numYears], 'readyEndDate' => $row[readyEndDate], 'domain' => $row[domain])));
    exit();
} else if (isset($_POST[calculate])) {
    $totalDay = 365;
    $isFree = TRUE;
    
    $sql = "SELECT pro_price, pro_price_exclude_vat FROM ready_product WHERE pro_year = '$_POST[package]' AND pro_pcode = '57PB';";
    $query = mysql_db_query($dbname, $sql);
    $row = mysql_fetch_array($query);

    //cal day
    $start = new DateTime($_POST[dateFrom]);
    $end = new DateTime($_POST[dateTo]);
    $day = $start->diff($end);
    $day = $day->format('%a') + 1;
    
    //check package
    $totalDay = $totalDay * $_POST[package];
    
    if (($_POST[package] == 1 && $day < $totalDay) || ($_POST[package] == 2 && $day < $totalDay) || ($_POST[package] == 3 && $day < $totalDay)) {
        $isFree = FALSE;
    }

    //price per day
    $priceVat = (!$isFree) ? $row[pro_price] / $totalDay : $row[pro_price];
    
    $price = (!$isFree) ? $row[pro_price_exclude_vat] / $totalDay : $row[pro_price_exclude_vat];

    //total price
    $sumVat = (!$isFree) ? ($priceVat * $day) * $_POST[seats] : $priceVat * $_POST[seats];
    $sumVat = number_format($sumVat, 2, '.', '');
    
    $sum = (!$isFree) ? ($price * $day) * $_POST[seats] : $price * $_POST[seats];
    $sum = number_format($sum, 2, '.', '');

    if(!$isFree){
        echo json_encode(array("results" => array('summary' => "Total day: $day<br/>Price exclude VAT: $sum<br/>Price include VAT: $sumVat")));
    }else{
        echo json_encode(array("results" => array('summary' => "This account is in the free period.<br/>price exclude VAT: $sum<br/>price include VAT: $sumVat")));
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Calculator GoogleApp</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

        <script>
            $(document).ready(function () {
                $("button[name='search']").click(function () {
                    getDomain();
                });

                $("button[name='calculate']").click(function () {
                    if(checkValidate()){
                        getCalResult();
                    }
                });
            });
            
            function checkValidate() {
                var domain = $("input[name='domain']");
                var startDate = $("input[name='dateFrom']");
                
                
                if(!domain.val()){
                    domain.parent("div").addClass("has-error");
                    return false;
                }else{
                    domain.parent("div").removeClass("has-error");
                }
                
                
                if(!startDate.val()){
                    startDate.parent("div").addClass("has-error");
                    return false;
                }else{
                    startDate.parent("div").removeClass("has-error");
                }
                
                
                return true;
            }

            function getDomain() {
                $("button[name='search']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='search']").attr("disabled", "disabled");

                //ajax call
                $.post("calculator_gapp.php",
                        {
                            search: "",
                            domain: $("input[name='domain']").val()
                        }
                )
                        .done(function (data) {
                            $("button[name='search']").html("Search");
                            $("button[name='search']").removeAttr("disabled");

                            var JSONArray = $.parseJSON(data);

                            if (JSONArray.hasOwnProperty('error')) {
                                alert(JSONArray.error.message);
                            }
                            else if (JSONArray.hasOwnProperty('results')) {
                                $("input[name='package']").val(JSONArray.results.numYears);
                                $("input[name='seats']").val(1);
                                $("input[name='dateTo']").val(JSONArray.results.readyEndDate);
                                $("input[name='domain']").val(JSONArray.results.domain);
                            }
                        });
            }


            function getCalResult() {
                $("button[name='calculate']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='calculate']").attr("disabled", "disabled");

                //ajax call
                $.post("calculator_gapp.php",
                        {
                            calculate: "",
                            package: $("input[name='package']").val(),
                            seats: $("input[name='seats']").val(),
                            dateFrom: $("input[name='dateFrom']").val(),
                            dateTo: $("input[name='dateTo']").val()
                        }
                )
                        .done(function (data) {
                            $("button[name='calculate']").html("Calculate");
                            $("button[name='calculate']").removeAttr("disabled");

                            var JSONArray = $.parseJSON(data);

                            if (JSONArray.hasOwnProperty('error')) {
                                alert(JSONArray.error.message);
                            }
                            else if (JSONArray.hasOwnProperty('results')) {
                                $("#result").html(JSONArray.results.summary);
                            }
                        });
            }
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Calculator GoogleApp</h2></div>

            <div class="form-group">
                <label class="control-label col-md-5">Domain:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="domain" />
                </div>

                <div class="col-md-2" style="color: #d9534f;" align='left'>
                    <font>* กรุณากรอกโดเมน</font><br/>
                    
                    <button name="search" class="btn btn-default">Search</button>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-5">Package:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="package" disabled />
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-5">จำนวนผู้ใช้ที่ต้องการเพิ่ม:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="seats" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-5">Start Date:</label>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="dateFrom" />
                </div>
                
                <div class="col-md-2" style="color: #d9534f;" align='left'>
                    <font>* กรุณาระบุวันที่</font>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-5">End Date:</label>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="dateTo" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button name="calculate" class="btn btn-default">Calculate</button>
                </div>
            </div>


        </div>

        <div class="panel panel-warning col-md-offset-4 col-md-4">
            <div class="panel-heading">Result</div>
            <div class="panel-body" id="result"></div>
        </div>
    </body>
</html>